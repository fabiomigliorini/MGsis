<?php

class m140128_150635_adiciona_totais_tblliquidacaotitulo extends CDbMigration
{

	public function up()
	{
		// Adiciona DEBITO / CREDITO
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo add debito numeric(14,2)')->execute();
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo add credito numeric(14,2)')->execute();
		
		// Adiciona CODPESSOA
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo add codpessoa BIGINT')->execute();
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo add foreign key (codpessoa) references tblpessoa (codpessoa)')->execute();
		
		// Atualiza TOTAIS das colunas
		Yii::app()->db->createCommand('		
			update tblliquidacaotitulo
			set 
				codpessoa = q.codpessoa,
				debito = q.debito,
				credito = q.credito
			from (
				SELECT 
					  tblmovimentotitulo.codliquidacaotitulo
					, min(tbltitulo.codpessoa) as codpessoa
					, sum(coalesce(tblmovimentotitulo.debito, 0)) AS debito
					, sum(coalesce(tblmovimentotitulo.credito, 0)) AS credito
				 FROM tblmovimentotitulo
			    INNER JOIN tbltitulo ON tbltitulo.codtitulo = tblmovimentotitulo.codtitulo
			    WHERE tblmovimentotitulo.codtipomovimentotitulo = 600 
				  AND tblmovimentotitulo.codliquidacaotitulo IS NOT NULL
				GROUP BY tblmovimentotitulo.codliquidacaotitulo
				  ) q
			where tblliquidacaotitulo.codliquidacaotitulo = q.codliquidacaotitulo
			')->execute();
		
		// Aquilo que nao achou codpessoa, coloca como 1-Consumidor
		Yii::app()->db->createCommand('update tblliquidacaotitulo set codpessoa = 1 where codpessoa is null')->execute();
		
		// Marca CODPESSOA como NOT NULL
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo alter column codpessoa SET NOT NULL')->execute();

		// Ajusta TRIGGER tblmovimentotitulo para somar totais da LIQUIDACAO
		Yii::app()->db->createCommand('
			CREATE OR REPLACE FUNCTION fntblmovimentotituloaiauad()
			  RETURNS trigger AS
			$BODY$
				DECLARE

				vCodTitulo bigint;
				vCodLiquidacaoTitulo bigint;

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
					vCodLiquidacaoTitulo = OLD.codLiquidacaoTitulo;
				ELSE
					vCodTitulo = NEW.codTitulo;
					vCodLiquidacaoTitulo = NEW.codLiquidacaoTitulo;
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

				-- Atualiza Tabela tblliquidacaotitulos
				IF vCodLiquidacaoTitulo	IS NOT NULL THEN
					update tblliquidacaotitulo
					set 
						debito = q.debito,
						credito = q.credito
					from (
						SELECT 
							  tblmovimentotitulo.codliquidacaotitulo
							, sum(coalesce(tblmovimentotitulo.debito, 0)) AS debito
							, sum(coalesce(tblmovimentotitulo.credito, 0)) AS credito
						FROM tblmovimentotitulo
						WHERE tblmovimentotitulo.codliquidacaotitulo = vCodLiquidacaoTitulo
						AND tblmovimentotitulo.codtipomovimentotitulo = 600 
						GROUP BY tblmovimentotitulo.codliquidacaotitulo
						) q
					where tblliquidacaotitulo.codliquidacaotitulo = vCodLiquidacaoTitulo
					and tblliquidacaotitulo.codliquidacaotitulo = q.codliquidacaotitulo;
				END IF;

				RETURN NEW;

				END;
			$BODY$
			  LANGUAGE plpgsql VOLATILE
			  COST 100;
			ALTER FUNCTION fntblmovimentotituloaiauad()
			  OWNER TO mgsis;
			')->execute();

		
		
	}

	public function down()
	{
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo drop column debito')->execute();
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo drop column credito')->execute();
		Yii::app()->db->createCommand('alter table tblliquidacaotitulo drop column codpessoa')->execute();		
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
