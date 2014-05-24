<?php

class m140524_125448_totais_tabela_notafiscal extends CDbMigration
{
	public function up()
	{

		/* Desabilita todas as triggers de tblnotafiscal */
		Yii::app()->db->createCommand('ALTER TABLE tblnotafiscal DISABLE TRIGGER ALL ')->execute();
		Yii::app()->db->createCommand('ALTER TABLE tblnotafiscal DISABLE TRIGGER ALL ')->execute();
		
		/* valor produtos e total */
		Yii::app()->db->createCommand('alter table tblnotafiscal add valorprodutos numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add valortotal    numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add icmsbase      numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add icmsvalor     numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add icmsstbase    numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add icmsstvalor   numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add ipibase       numeric(14,2) NOT NULL DEFAULT 0')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal add ipivalor      numeric(14,2) NOT NULL DEFAULT 0')->execute();
	
		/* cria regra de excecao na auditoria pra nao replicar os campos de totais criados */
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (14, \'tblnotafiscal\', \'valorprodutos\')')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (15, \'tblnotafiscal\', \'valortotal\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (16, \'tblnotafiscal\', \'icmsbase\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (17, \'tblnotafiscal\', \'icmsvalor\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (18, \'tblnotafiscal\', \'icmsstbase\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (19, \'tblnotafiscal\', \'icmsstvalor\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (20, \'tblnotafiscal\', \'ipibase\'   )')->execute();
		Yii::app()->db->createCommand('insert into tblauditoriaexcecao (codauditoriaexcecao, tabela, campo) values (21, \'tblnotafiscal\', \'ipivalor\'   )')->execute();

		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnotafiscal_atualiza_valortotal(pCodNotaFiscal BIGINT)
			  RETURNS BOOLEAN AS
			$BODY$
			BEGIN

				-- Atualiza Tabela com valores calculados
				UPDATE tblNotaFiscal
				   SET valorTotal  = 
						coalesce(tblNotaFiscal.valorProdutos, 0)
						+ coalesce(tblNotaFiscal.icmsstvalor, 0)
						+ coalesce(tblNotaFiscal.ipivalor, 0)
						+ coalesce(tblNotaFiscal.valorfrete, 0)
						+ coalesce(tblNotaFiscal.valorseguro, 0)
						- coalesce(tblNotaFiscal.valordesconto, 0)
						+ coalesce(tblNotaFiscal.valoroutras, 0)
				 WHERE tblNotaFiscal.CodNotaFiscal = pCodNotaFiscal;

				RETURN TRUE;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnotafiscal_atualiza_valortotal(pCodNotaFiscal BIGINT)
			  OWNER TO mgsis;
			')->execute();
		
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnotafiscal_atualiza_valorprodutos(pCodNotaFiscal BIGINT)
			  RETURNS BOOLEAN AS
			$BODY$
			DECLARE
				vValorProdutos numeric (14,2);
				vIcmsBase      numeric (14,2);
				vIcmsValor     numeric (14,2);
				vIcmsStBase    numeric (14,2);
				vIcmsStValor   numeric (14,2);
				vIpiBase       numeric (14,2);
				vIpiValor      numeric (14,2);
			BEGIN

				-- calcula total produtos
				SELECT 
				  INTO vValorProdutos
				     , vIcmsBase
				     , vIcmsValor
				     , vIcmsStBase
				     , vIcmsStValor
				     , vIpiBase
				     , vIpiValor
					   SUM(COALESCE(tblNotaFiscalProdutoBarra.valortotal, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IcmsBase, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IcmsValor, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IcmsStBase, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IcmsStValor, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IpiBase, 0))
					 , SUM(COALESCE(tblNotaFiscalProdutoBarra.IpiValor, 0))
					   
				FROM tblNotaFiscalProdutoBarra
				WHERE tblNotaFiscalProdutoBarra.codNotaFiscal = pCodNotaFiscal;

				-- Atualiza Tabela com valores calculados
				UPDATE tblNotaFiscal
				   SET valorProdutos   = coalesce(vValorProdutos, 0)
				     , IcmsBase       = coalesce(vIcmsBase     , 0)
				     , IcmsValor      = coalesce(vIcmsValor    , 0)
				     , IcmsStBase     = coalesce(vIcmsStBase   , 0)
				     , IcmsStValor    = coalesce(vIcmsStValor  , 0)
				     , IpiBase        = coalesce(vIpiBase      , 0)
				     , IpiValor       = coalesce(vIpiValor     , 0)
				 WHERE tblNotaFiscal.CodNotaFiscal = pCodNotaFiscal;

				RETURN TRUE;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnotafiscal_atualiza_valorprodutos(pCodNotaFiscal BIGINT)
			  OWNER TO mgsis;			
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnotafiscalaiau_valorprodutos()
			  RETURNS trigger AS
			$BODY$

			DECLARE
				vRetorno BOOLEAN;
			BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorTotal(OLD.codNotaFiscal);
				ELSIF (TG_OP = \'INSERT\') THEN
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorTotal(NEW.codNotaFiscal);
				ELSE 
					IF (NEW.codNotaFiscal <> OLD.codNotaFiscal) THEN
						SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorTotal(OLD.codNotaFiscal);
					END IF;
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorTotal(NEW.codNotaFiscal);
				END IF;

				RETURN NEW;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnotafiscalaiau_valorprodutos()
			  OWNER TO mgsis;
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblnotafiscalprodutobarraaiauad()
			  RETURNS trigger AS
			$BODY$

			DECLARE
				vRetorno BOOLEAN;
			BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorProdutos(OLD.codNotaFiscal);
				ELSIF (TG_OP = \'INSERT\') THEN
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorProdutos(NEW.codNotaFiscal);
				ELSE 
					IF (NEW.codNotaFiscal <> OLD.codNotaFiscal) THEN
						SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorProdutos(OLD.codNotaFiscal);
					END IF;
					SELECT INTO vRetorno fnTblNotaFiscal_Atualiza_ValorProdutos(NEW.codNotaFiscal);
				END IF;

				RETURN NEW;

			END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblnotafiscalprodutobarraaiauad()
			  OWNER TO mgsis;
			')->execute();

		
		/* Triggers */
		Yii::app()->db->createCommand('
			CREATE TRIGGER tblnotafiscalprodutobarraaiauad
			AFTER INSERT OR UPDATE OR DELETE
			ON tblnotafiscalprodutobarra
			FOR EACH ROW
			EXECUTE PROCEDURE fntblnotafiscalprodutobarraaiauad();
			')->execute();
		
		Yii::app()->db->createCommand('
			CREATE TRIGGER tblnotafiscalaiau_valorprodutos
			AFTER INSERT OR UPDATE OF 
					  valorProdutos
					, valorfrete
					, valorseguro
					, valordesconto
					, valoroutras
					, icmsstvalor
					, ipivalor
			ON tblnotafiscal
			FOR EACH ROW
			EXECUTE PROCEDURE fntblnotafiscalaiau_valorprodutos();			
			')->execute();
		
		
		/* forca execucao das triggers pra poder atualizar campos com totais */
		Yii::app()->db->createCommand('UPDATE tblnotafiscalprodutobarra  SET codnotafiscal=codnotafiscal')->execute();
		Yii::app()->db->createCommand('update tblnotafiscal set valordesconto = coalesce(valordesconto, 0) where valorprodutos <= 0')->execute();
		
		/* habilita todas as triggers de tblnotafiscal */
		Yii::app()->db->createCommand('ALTER TABLE tblnotafiscal ENABLE TRIGGER ALL ')->execute();
		
	}

	public function down()
	{
		
		
		/*
		Yii::app()->db->createCommand('DROP TRIGGER tblnotafiscalprodutobarraaiauad ON tblnotafiscalprodutobarra')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscalprodutobarraaiauad()')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER tblnotafiscalformapagamentoaiauad ON tblnotafiscalformapagamento')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscalformapagamentoaiauad()')->execute();
		 * 
		 */
		Yii::app()->db->createCommand('delete from tblauditoriaexcecao where codauditoriaexcecao in (14, 15, 16, 17, 18, 19, 20, 21)')->execute();
		
		Yii::app()->db->createCommand('DROP TRIGGER tblnotafiscalaiau_valorprodutos ON tblnotafiscal')->execute();
		Yii::app()->db->createCommand('DROP TRIGGER tblnotafiscalprodutobarraaiauad ON tblnotafiscalprodutobarra')->execute();
		
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscalaiau_valorprodutos()')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscalprodutobarraaiauad()')->execute();
		
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscal_atualiza_valorprodutos(pCodNotaFiscal BIGINT)')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION fntblnotafiscal_atualiza_valortotal(pCodNotaFiscal BIGINT)')->execute();

		Yii::app()->db->createCommand('alter table tblnotafiscal drop column valorprodutos')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column valortotal')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column icmsbase')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column icmsvalor')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column icmsstbase')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column icmsstvalor')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column ipibase')->execute();
		Yii::app()->db->createCommand('alter table tblnotafiscal drop column ipivalor')->execute();
		
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