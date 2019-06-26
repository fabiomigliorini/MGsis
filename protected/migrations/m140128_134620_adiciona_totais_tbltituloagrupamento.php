<?php

class m140128_134620_adiciona_totais_tbltituloagrupamento extends CDbMigration
{
	public function up()
	{
		// Adiciona DEBITO / CREDITO
		Yii::app()->db->createCommand('alter table tbltituloagrupamento add debito numeric(14,2)')->execute();
		Yii::app()->db->createCommand('alter table tbltituloagrupamento add credito numeric(14,2)')->execute();
		
		// Adiciona CODPESSOA
		Yii::app()->db->createCommand('alter table tbltituloagrupamento add codpessoa BIGINT')->execute();
		Yii::app()->db->createCommand('alter table tbltituloagrupamento add foreign key (codpessoa) references tblpessoa (codpessoa)')->execute();
		
		// Atualiza TOTAIS das colunas
		Yii::app()->db->createCommand('		
			update tbltituloagrupamento
			set 
				codpessoa = q.codpessoa,
				debito = q.debito,
				credito = q.credito
			from (
				select 
					tbltitulo.codtituloagrupamento, 
					min(tbltitulo.codpessoa) as codpessoa, 
					sum(coalesce(tbltitulo.debito, 0)) as debito, 
					sum(coalesce(tbltitulo.credito, 0)) as credito
				from tbltitulo
				where tbltitulo.codtituloagrupamento is not null
				group by tbltitulo.codtituloagrupamento
				) q
			where tbltituloagrupamento.codtituloagrupamento = q.codtituloagrupamento
			')->execute();
		
		// Aquilo que nao achou codpessoa, coloca como 1-Consumidor
		Yii::app()->db->createCommand('update tbltituloagrupamento set codpessoa = 1 where codpessoa is null')->execute();
		
		// Marca CODPESSOA como NOT NULL
		Yii::app()->db->createCommand('alter table tbltituloagrupamento alter column codpessoa SET NOT NULL')->execute();

		// Marca CODPESSOA como NOT NULL
		Yii::app()->db->createCommand('alter table tbltituloagrupamento alter column codpessoa SET NOT NULL')->execute();

		// Ajusta TRIGGER tblmovimentotitulo para somar totais do TITULO
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblmovimentotituloaiauad()
			  RETURNS trigger AS
			$BODY$
				DECLARE

				vCodTitulo bigint;

				vTransacaoLiquidacao date;
				vTransacaoEstorno timestamp without time zone;

				vDebitoTotal numeric (14,2);
				vDebitoSaldo numeric (14,2);

				vCreditoTotal numeric (14,2);
				vCreditoSaldo numeric (14,2);

				vSaldo numeric (14,2);

				BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					vCodTitulo = OLD.codTitulo;
				ELSE
					vCodTitulo = NEW.codTitulo;
				END IF;

				-- calcula total Debito e Credito
				SELECT 
				  INTO vDebitoTotal
					 , vCreditoTotal
					   SUM(COALESCE(tblMovimentoTitulo.Debito, 0))
					 , SUM(COALESCE(tblMovimentoTitulo.Credito, 0))
				FROM tblMovimentoTitulo
				WHERE tblMovimentoTitulo.codTitulo = vCodTitulo;

				-- calcula Saldo
				vSaldo := COALESCE(vDebitoTotal, 0) - COALESCE(vCreditoTotal, 0);
				vTransacaoLiquidacao := NULL;
				vTransacaoEstorno := NULL;

				-- calcula DebitoSaldo e CreditoSaldo
				IF vSaldo > 0 THEN 
					vDebitoSaldo := vSaldo;
					vCreditoSaldo := 0;
				ELSIF vSaldo < 0 THEN 
					vDebitoSaldo := 0;
					vCreditoSaldo := vSaldo * -1;
				ELSE
					vDebitoSaldo := 0;
					vCreditoSaldo := 0;

					-- Pega data estorno
					SELECT INTO vTransacaoEstorno MAX(COALESCE(criacao, sistema)) 
					  FROM tblMovimentoTitulo
					 WHERE tblMovimentoTitulo.codTitulo = vCodTitulo
					   AND tblMovimentoTitulo.codTipoMovimentoTitulo = 900;

					-- Pega data liquidacao
					SELECT INTO vTransacaoLiquidacao MAX(Transacao) 
					  FROM tblMovimentoTitulo 
					 WHERE tblMovimentoTitulo.codTitulo = vCodTitulo;

				END IF;

				-- Atualiza Tabela com valores calculados
				UPDATE tblTitulo
				   SET DebitoTotal         = vDebitoTotal
					 , CreditoTotal        = vCreditoTotal
					 , DebitoSaldo         = vDebitoSaldo
					 , CreditoSaldo        = vCreditoSaldo
					 , Saldo               = vSaldo
					 , TransacaoLiquidacao = vTransacaoLiquidacao
					 , Estornado           = vTransacaoEstorno
				 WHERE tblTitulo.codTitulo = vCodTitulo;

				RETURN NEW;

				END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblmovimentotituloaiauad()
			  OWNER TO mgsis;
			')->execute();

		// Trigger tbltitulo para Atualizar total debito/credito do agrupamento
		Yii::app()->db->createCommand('		
			CREATE OR REPLACE FUNCTION fntbltituloaiauad()
			  RETURNS trigger AS
			$BODY$
				DECLARE
				vCodTituloAgrupamento bigint;
				vDebitoTotal numeric (14,2);
				vCreditoTotal numeric (14,2);
				BEGIN

				-- Descobre codTitulo
				IF (TG_OP = \'DELETE\') THEN
					vCodTituloAgrupamento = OLD.codTituloAgrupamento;
				ELSE
					vCodTituloAgrupamento = NEW.codTituloAgrupamento;
				END IF;

				IF vCodTituloAgrupamento IS NOT NULL THEN

					update tbltituloagrupamento
					set 
						debito = q.debito,
						credito = q.credito
					from (
						select 
							tbltitulo.codtituloagrupamento, 
							sum(coalesce(tbltitulo.debito, 0)) as debito, 
							sum(coalesce(tbltitulo.credito, 0)) as credito
						from tbltitulo
						where tbltitulo.codtituloagrupamento = vCodTituloAgrupamento
						group by tbltitulo.codtituloagrupamento
						) q
					where tbltituloagrupamento.codtituloagrupamento = vCodTituloAgrupamento
					AND tbltituloagrupamento.codtituloagrupamento = q.codtituloagrupamento;

				END IF;

				RETURN NEW;

				END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblmovimentotituloaiauad()
			  OWNER TO mgsis;
			')->execute();

		Yii::app()->db->createCommand('		
			CREATE TRIGGER tbltituloaiauad
			  AFTER INSERT OR UPDATE OR DELETE
			  ON tbltitulo
			  FOR EACH ROW
			  EXECUTE PROCEDURE fntbltituloaiauad();
			')->execute();
		
		
	}

	public function down()
	{
		Yii::app()->db->createCommand('DROP TRIGGER tbltituloaiauad ON TBLTITULO')->execute();
		Yii::app()->db->createCommand('DROP FUNCTION DROP FUNCTION fntbltituloaiauad()')->execute();
		Yii::app()->db->createCommand('alter table tbltituloagrupamento drop column debito')->execute();
		Yii::app()->db->createCommand('alter table tbltituloagrupamento drop column credito')->execute();
		Yii::app()->db->createCommand('alter table tbltituloagrupamento drop column codpessoa')->execute();		
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