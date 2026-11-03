# NFe de Terceiro com itens duplicados — como corrigir

Roteiro para quando uma NFe de Terceiro aparece com os produtos em dobro. A correção é feita direto no banco, com SQL rodado à mão. Por decisão, o código não foi corrigido, porque o MGsis será substituído.

## Sintomas

- Cada produto aparece **duas vezes** na nota. Uma cópia tem o trabalho feito (produto informado, conjuntos abertos). A outra vem "crua": sem produto informado e com o conjunto de caixas fechado.
- **Outros Custos** aparece com o dobro do complemento (CPL). Reinformar o CPL pela tela continua dando o dobro.
- Os itens repetidos aparecem como criados por um usuário que diz não ter mexido na nota.

## Por que acontece

1. **Abrir um conjunto de caixas (Dividir) renumera todos os itens da nota.** O número de cada item é multiplicado por 100: o item 1 vira 100, o 2 vira 200, e assim por diante. As partes de um conjunto ficam em 101, 102... (`NfeTerceiroItemController::actionDividirSalvar`; no MGspa, `NfeTerceiroItemService::dividir`).
2. **Quando o XML da nota é lido de novo, o sistema procura os itens pelo número original** (1, 2, 3...). Não acha nenhum e cria todos outra vez (`NFePHPDistDfeService::processarProcNFe` no MGspa e `NfeTerceiro::importarXml` no MGsis).
3. **O que faz o XML ser lido de novo:**
   - o botão **Download Nfe**, sempre;
   - os botões **XML** e **Danfe**, só quando a nota ainda não tinha sido baixada para o servidor;
   - o **Importar** feito pelo MGspa, com a mesma regra do XML/Danfe;
   - o robô de consulta da SEFAZ (a cada 30 min), se o XML completo chegar depois;
   - o upload de XML.
4. As cópias ficam registradas com o usuário que estava logado na hora. Às vezes foi só um clique no Danfe.
5. O CPL dobra porque o rateio é feito por item: `CPL / valor dos produtos da nota * valor do item`. Com os itens em dobro, a soma dobra.

## 1. Encontrar as notas afetadas

```sql
select a.codnfeterceiro, n.numero, n.emitente, n.codnotafiscal,
       count(*) as itens_duplicados, min(a.criacao) as duplicado_em
  from tblnfeterceiroitem a
  join tblnfeterceiroitem b on b.codnfeterceiro = a.codnfeterceiro
                           and b.nitem = a.nitem * 100
                           and (b.cprod = a.cprod or b.cprod like a.cprod || ' __/__%')
  join tblnfeterceiro n on n.codnfeterceiro = a.codnfeterceiro
 where a.nitem < 100
 group by 1, 2, 3, 4
 order by duplicado_em desc;
```

Interessam as notas **recentes com `codnotafiscal` vazio**. Em 11/2026 essa consulta também trazia notas antigas já importadas (Migliorini de 2022 a 03/2026, com 1 ou 2 itens; CW e Paloni de 2017/2018). Elas não fazem parte deste problema e não devem ser mexidas.

## 2. Diagnóstico da nota

Nos SQLs abaixo, troque `:codnfeterceiro` pelo id da nota, que é o número no fim da URL `nfeTerceiro/view/...`. No DBeaver ele pergunta o valor sozinho; no psql, use `\set codnfeterceiro 84982`.

Itens da nota, com quem criou e quando:

```sql
select i.codnfeterceiroitem, i.nitem, i.cprod, left(i.xprod, 45) as xprod, i.qcom, i.vprod,
       i.codprodutobarra, i.complemento,
       i.criacao, uc.usuario as criado_por, i.alteracao, ua.usuario as alterado_por
  from tblnfeterceiroitem i
  left join tblusuario uc on uc.codusuario = i.codusuariocriacao
  left join tblusuario ua on ua.codusuario = i.codusuarioalteracao
 where i.codnfeterceiro = :codnfeterceiro
 order by i.nitem;
```

- **Cópias:** `nitem` abaixo de 100, todas criadas no mesmo segundo e sem produto.
- **Originais:** `nitem` de 100 para cima.

Resumo para decidir se pode corrigir:

```sql
select max(n.numero)                                                as numero,
       max(n.codnotafiscal)                                         as codnotafiscal,
       max(n.codnegocio)                                            as codnegocio,
       max(n.valorprodutos)                                         as valorprodutos,
       count(*)          filter (where i.nitem < 100)               as copias,
       count(*)          filter (where i.nitem >= 100)              as originais,
       sum(i.vprod)      filter (where i.nitem < 100)               as vprod_copias,
       sum(i.vprod)      filter (where i.nitem >= 100)              as vprod_originais,
       count(*)          filter (where i.nitem >= 100
                                   and i.codprodutobarra is null)   as originais_sem_produto,
       max(i.nitem)                                                 as maior_nitem
  from tblnfeterceiroitem i
  join tblnfeterceiro n on n.codnfeterceiro = i.codnfeterceiro
 where i.codnfeterceiro = :codnfeterceiro;
```

**Só siga para a correção se:**

- `codnotafiscal` e `codnegocio` estiverem **vazios**, ou seja, a nota ainda não foi importada;
- `vprod_copias` = `vprod_originais` = `valorprodutos`;
- `maior_nitem` for **menor que 10000**, ou seja, o XML tem menos de 100 itens.

Se `originais_sem_produto` for maior que zero, a correção ainda pode ser feita. Depois, a operadora completa esses itens pela tela.

Antes de começar, pergunte à operadora **qual é o valor correto do CPL** da nota.

## 3. Correção

Troque `:cpl` pelo valor correto do CPL, com ponto decimal (ex.: `3642.00`).

```sql
begin;

-- 3.1) apaga as cópias e também as partes de cópias que tenham sido divididas depois.
--      O número de linhas apagadas tem que ser igual a "copias" do diagnóstico.
delete from tblnfeterceiroitem
 where codnfeterceiro = :codnfeterceiro
   and nitem < 100;

-- 3.2) confere o CPL que sobrou nos originais
select sum(complemento) as complemento_atual, :cpl as complemento_correto
  from tblnfeterceiroitem
 where codnfeterceiro = :codnfeterceiro;
```

Conforme o resultado de 3.2:

- **Igual ao CPL correto:** pule para 3.5.
- **Diferença de centavos** (arredondamento, comum em conjunto dividido em várias partes): rode só o 3.4.
- **Diferença grande** (por exemplo, alguém reinformou o CPL pela metade para "compensar"): rode o 3.3 e depois o 3.4.

```sql
-- 3.3) refaz o rateio do CPL, com a mesma conta da tela
update tblnfeterceiroitem i
   set complemento = round((:cpl / n.valorprodutos) * i.vprod, 2)
  from tblnfeterceiro n
 where n.codnfeterceiro = i.codnfeterceiro
   and i.codnfeterceiro = :codnfeterceiro;

-- 3.4) joga a diferença de centavos no item de maior complemento
update tblnfeterceiroitem
   set complemento = complemento + (:cpl - (select sum(complemento)
                                              from tblnfeterceiroitem
                                             where codnfeterceiro = :codnfeterceiro))
 where codnfeterceiroitem = (select codnfeterceiroitem
                               from tblnfeterceiroitem
                              where codnfeterceiro = :codnfeterceiro
                              order by complemento desc nulls last
                              limit 1);
```

```sql
-- 3.5) conferência: todas as colunas "_ok" devem ser true
select count(*) filter (where i.nitem < 100)                     as copias,
       count(*) filter (where i.nitem < 100) = 0                 as copias_ok,
       sum(i.vprod)                                              as vprod,
       sum(i.vprod) = max(n.valorprodutos)                       as vprod_ok,
       sum(i.complemento)                                        as complemento,
       sum(i.complemento) = :cpl                                 as complemento_ok,
       max(n.valortotal) + sum(i.complemento)                    as custo_total
  from tblnfeterceiroitem i
  join tblnfeterceiro n on n.codnfeterceiro = i.codnfeterceiro
 where i.codnfeterceiro = :codnfeterceiro;

commit;   -- se alguma coluna "_ok" vier false: rollback
```

Depois do `commit`, abra a nota no MGsis e confira:

- cada produto aparece uma vez;
- os conjuntos continuam abertos;
- **Outros Custos** é igual ao CPL;
- **Custo Total** é igual a Valor Nota + CPL, o mesmo valor da coluna `custo_total` da conferência.

## Quando NÃO usar este roteiro

- **A nota já foi importada** (`codnotafiscal` ou `codnegocio` preenchido). Nesse caso estoque e financeiro já foram lançados em dobro, e apagar os itens não desfaz isso. Precisa de análise à parte.
- **O XML tem 100 itens ou mais** (`maior_nitem` ≥ 10000). A releitura do XML pode ter **sobrescrito** itens originais: o item 100 do XML cai em cima do item 1 já renumerado. Precisa de análise manual.
- **`vprod` não bate** entre cópias, originais e a nota.
- **O `delete` falha por chave estrangeira.** Faça `rollback` e veja qual tabela aponta para os itens.

## Como evitar (orientação para a equipe)

1. **Ao começar uma nota, abra o Danfe primeiro**, antes de informar produtos ou abrir conjuntos. Assim a nota fica baixada, e depois o Danfe e o XML podem ser abertos sem risco.
2. **Depois de abrir conjuntos de caixas, não clique em "Download Nfe".**
3. **Se aparecerem produtos repetidos ou Outros Custos dobrado, não tente refazer a nota.** Não informe os produtos de novo, não abra os conjuntos de novo e não reinforme o CPL. Chame o suporte e passe o número da nota.

## Histórico

- **NFe 84982**: CW Importadora, nº 79860, CPL 3.642,00.
  - 78 itens originais trabalhados em 27 e 28/10/2026.
  - Em 30/10/2026 às 14:15:21, 40 cópias foram criadas de uma vez.
  - Correção: as 40 cópias foram apagadas, e R$ 0,01 de arredondamento foi devolvido ao item 3900 (conjunto dividido em 10 partes). Os originais somavam 3.641,99.
- Uma nota anterior do mesmo fornecedor teve o mesmo problema. O número não ficou registrado.
