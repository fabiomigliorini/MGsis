-- Executar em produção somente após implantar a atualização de
-- NfeTerceiro::importar(), que passa a recalcular os totais do negócio.
-- Este script remove apenas as triggers; mantém as funções no banco.

BEGIN;

DROP TRIGGER IF EXISTS tblnegocioaiau_valorprodutos_valoraprazo_valordesconto_valorfre
    ON mgsis.tblnegocio;

DROP TRIGGER IF EXISTS tblnegocioformapagamentoaiauad
    ON mgsis.tblnegocioformapagamento;

DROP TRIGGER IF EXISTS tblnegocioprodutobarraaiauad
    ON mgsis.tblnegocioprodutobarra;

COMMIT;

-- Verificação: deve retornar zero linhas.
SELECT c.relname AS tabela, t.tgname AS trigger
  FROM pg_trigger t
  JOIN pg_class c ON c.oid = t.tgrelid
  JOIN pg_namespace n ON n.oid = c.relnamespace
 WHERE n.nspname = 'mgsis'
   AND t.tgname IN (
       'tblnegocioaiau_valorprodutos_valoraprazo_valordesconto_valorfre',
       'tblnegocioformapagamentoaiauad',
       'tblnegocioprodutobarraaiauad'
   )
   AND NOT t.tgisinternal;
