<?php

class m140419_195316_totais_tabela_negocio extends CDbMigration
{
	public function up()
	{

		/* Desabilita todas as triggers de tblnegocio */
		Yii::app()->db->createCommand('ALTER TABLE tblnegocio DISABLE TRIGGER ALL ')->execute();
		
		/* 
		 * NATUREZA DE OPERACAO
		 * Passa para 2 - "Devolução de Venda" - Quando Operacao 1
		 * Passa para 1 - "Venda             " - Quando Operacao 2
		 */
		Yii::app()->db->createCommand('alter table tblnegocio add codnaturezaoperacao bigint')->execute();
		Yii::app()->db->createCommand('update tblnegocio set codnaturezaoperacao = 2 where codoperacao = 1')->execute();
		Yii::app()->db->createCommand('update tblnegocio set codnaturezaoperacao = 1 where codoperacao = 2')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio alter column codnaturezaoperacao SET NOT NULL')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio add foreign key (codnaturezaoperacao) references tblnaturezaoperacao (codnaturezaoperacao)')->execute();
		
		/* valor produtos e total */
		Yii::app()->db->createCommand('alter table tblnegocio add valorprodutos numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio add valortotal    numeric(14,2) NOT NULL DEFAULT 0')->execute();
		
		/* valor prazo e a vista */
		Yii::app()->db->createCommand('alter table tblnegocio add valoraprazo   numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio add valoravista   numeric(14,2) NOT NULL DEFAULT 0')->execute();
		
		/* cria regra de excecao na auditoria pra nao replicar os campos de totais criados */
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (10, \'tblnegocio\', \'valorprodutos\')')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (11, \'tblnegocio\', \'valortotal\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (12, \'tblnegocio\', \'valoraprazo\'  )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (13, \'tblnegocio\', \'valoravista\'  )')->execute();
		
		/* Funcoes de Atualização dos campos */
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocio_atualiza_valoraprazo(pCodNegocio BIGINT)
			  RETURNS BOOLEAN AS
			$BODY$
			DECLARE
				vValoAPrazo numeric (14,2);
			BEGIN

				-- calcula total produtos
				SELECT 
				  INTO vValoAPrazo
					   SUM(COALESCE(tblnegocioformapagamento.valorpagamento, 0))
				  FROM tblnegocioformapagamento
				 INNER JOIN tblformapagamento ON tblformapagamento.codformapagamento = tblnegocioformapagamento.codformapagamento
				 WHERE tblnegocioformapagamento.CodNegocio = pCodNegocio
				   AND COALESCE(tblformapagamento.avista, true) = false;

				-- Atualiza Tabela com valores calculados
				UPDATE tblNegocio
				   SET valorAPrazo       = coalesce(vValoAPrazo, 0)
				 WHERE tblNegocio.CodNegocio = pCodNegocio;

				RETURN TRUE;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocio_atualiza_valoraprazo(pCodNegocio BIGINT)
			  OWNER TO mgsis;
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocio_atualiza_valortotal(pCodNegocio BIGINT)
			  RETURNS BOOLEAN AS
			$BODY$
			BEGIN

				-- Atualiza Tabela com valores calculados
				UPDATE tblNegocio
				   SET valorAVista = coalesce(tblNegocio.valorProdutos, 0) - coalesce(tblNegocio.valorDesconto, 0) - coalesce(tblNegocio.valorAPrazo, 0)
					 , valorTotal  = coalesce(tblNegocio.valorProdutos, 0) - coalesce(tblNegocio.valorDesconto, 0) 
				 WHERE tblNegocio.CodNegocio = pCodNegocio;

				RETURN TRUE;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocio_atualiza_valortotal(pCodNegocio BIGINT)
			  OWNER TO mgsis;
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocio_atualiza_valorprodutos(pCodNegocio BIGINT)
			  RETURNS BOOLEAN AS
			$BODY$
			DECLARE
				vValorProdutos numeric (14,2);
			BEGIN

				-- calcula total produtos
				SELECT 
				  INTO vValorProdutos
					   SUM(COALESCE(tblNegocioProdutoBarra.valortotal, 0))
				FROM tblNegocioProdutoBarra
				WHERE tblNegocioProdutoBarra.codNegocio = pCodNegocio;

				-- Atualiza Tabela com valores calculados
				UPDATE tblNegocio
				   SET valorProdutos       = coalesce(vValorProdutos, 0)
				 WHERE tblNegocio.CodNegocio = pCodNegocio;

				RETURN TRUE;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocio_atualiza_valorprodutos(pCodNegocio BIGINT)
			  OWNER TO mgsis;			
			')->execute();
		
		/* Funcoes para as Triggers */
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocioformapagamentoaiauad()
			  RETURNS trigger AS
			$BODY$
			DECLARE
				vRetorno BOOLEAN;
			BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorAPrazo(OLD.codNegocio);
				ELSIF (TG_OP = \'INSERT\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorAPrazo(NEW.codNegocio);
				ELSE 
					IF (NEW.codNegocio <> OLD.codNegocio) THEN
						SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorAPrazo(OLD.codNegocio);
					END IF;
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorAPrazo(NEW.codNegocio);
				END IF;

				RETURN NEW;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocioformapagamentoaiauad()
			  OWNER TO mgsis;			
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocioaiau_valorprodutos_valoraprazo_valordesconto()
			  RETURNS trigger AS
			$BODY$

			DECLARE
				vRetorno BOOLEAN;
			BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorTotal(OLD.codNegocio);
				ELSIF (TG_OP = \'INSERT\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorTotal(NEW.codNegocio);
				ELSE 
					IF (NEW.codNegocio <> OLD.codNegocio) THEN
						SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorTotal(OLD.codNegocio);
					END IF;
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorTotal(NEW.codNegocio);
				END IF;

				RETURN NEW;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocioaiau_valorprodutos_valoraprazo_valordesconto()
			  OWNER TO mgsis;
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnegocioprodutobarraaiauad()
			  RETURNS trigger AS
			$BODY$

			DECLARE
				vRetorno BOOLEAN;
			BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorProdutos(OLD.codNegocio);
				ELSIF (TG_OP = \'INSERT\') THEN
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorProdutos(NEW.codNegocio);
				ELSE 
					IF (NEW.codNegocio <> OLD.codNegocio) THEN
						SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorProdutos(OLD.codNegocio);
					END IF;
					SELECT INTO vRetorno fnTblNegocio_Atualiza_ValorProdutos(NEW.codNegocio);
				END IF;

				RETURN NEW;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnegocioprodutobarraaiauad()
			  OWNER TO mgsis;
			')->execute();

		
		/* Triggers */
		Yii::app()->db->createCommand('
			CREATE TRIGGER tblnegocioprodutobarraaiauad
			AFTER INSERT OR UPDATE OR DELETE
			ON tblnegocioprodutobarra
			FOR EACH ROW
			EXECUTE PROCEDURE fntblnegocioprodutobarraaiauad();
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE TRIGGER tblnegocioformapagamentoaiauad
			AFTER INSERT OR UPDATE OR DELETE
			ON tblnegocioformapagamento
			FOR EACH ROW
			EXECUTE PROCEDURE fntblnegocioformapagamentoaiauad();		
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE TRIGGER tblnegocioaiau_valorprodutos_valoraprazo_valordesconto
			AFTER INSERT OR UPDATE OF valorProdutos, valorAPrazo, valorDesconto
			ON tblnegocio
			FOR EACH ROW
			EXECUTE PROCEDURE fntblnegocioaiau_valorprodutos_valoraprazo_valordesconto();			
			')->execute();
		
		
		/* forca execucao das triggers pra poder atualizar campos com totais */
		Yii::app()->db->createCommand('UPDATE TBLNEGOCIOFORMAPAGAMENTO SET CODNEGOCIO=CODNEGOCIO')->execute();
		Yii::app()->db->createCommand('UPDATE tblnegocioprodutobarra  SET CODNEGOCIO=CODNEGOCIO')->execute();
		Yii::app()->db->createCommand('update tblnegocio set valordesconto = valordesconto where valordesconto is not null and valorprodutos <= 0')->execute();
		
		/* habilita todas as triggers de tblnegocio */
		Yii::app()->db->createCommand('ALTER TABLE tblnegocio ENABLE TRIGGER ALL ')->execute();
		
	}

	public function down()
	{
		
		
		/*
		Yii::app()->db->createCommand('DROP TRIGGER tblnegocioprodutobarraaiauad ON tblnegocioprodutobarra')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocioprodutobarraaiauad()')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER tblnegocioformapagamentoaiauad ON tblnegocioformapagamento')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocioformapagamentoaiauad()')->execute();
		 * 
		 */
		Yii::app()->db->createCommand('delete from tblauditoriaexcecao where codauditoriaexcecao in (10, 11, 12, 13)')->execute();
		
		Yii::app()->db->createCommand('DROP TRIGGER tblnegocioaiau_valorprodutos_valoraprazo_valordesconto ON tblnegocio')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER tblnegocioformapagamentoaiauad ON tblnegocioformapagamento')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER tblnegocioprodutobarraaiauad ON tblnegocioprodutobarra')->execute();
		
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocioformapagamentoaiauad()')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocioaiau_valorprodutos_valoraprazo_valordesconto()')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocioprodutobarraaiauad()')->execute();
		
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocio_atualiza_valorprodutos(pCodNegocio BIGINT)')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocio_atualiza_valortotal(pCodNegocio BIGINT)')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnegocio_atualiza_valoraprazo(pCodNegocio BIGINT)')->execute();

		Yii::app()->db->createCommand('alter table tblnegocio drop column codnaturezaoperacao')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio drop column valorprodutos')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio drop column valortotal')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio drop column valoraprazo')->execute();
		Yii::app()->db->createCommand('alter table tblnegocio drop column valoravista')->execute();
		
		return true;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}