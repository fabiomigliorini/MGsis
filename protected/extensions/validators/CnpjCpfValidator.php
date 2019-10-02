<?php
/**
 * CNPJValidator class file.
 *
 * @author Rodrigo S Nurmberg <rsn86@rsn86.com>
 * @link http://twitter.com/rsn1986/
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CNPJValidator valida um CNPJ brasileiro conforme algoritimo de geração.
 * @author Rodrigo S Nurmberg <rsn86@rsn86.com>
 * @version 0.1
 */
class CnpjCpfValidator extends CValidator
{
    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel the data object being validated
     * @param string the name of the attribute to be validated.
     */
    protected function validateAttribute($object, $attribute)
    {
				if ($object instanceof Pessoa) {
	        if ($object->codpessoa == Pessoa::CONSUMIDOR) {
            return true;
	        }
				}

				if ($object instanceof Negocio || $object instanceof NotaFiscal) {
          if (empty($object->$attribute)) {
            return true;
          }
				}

        if (!$this->validaCNPJ($object->$attribute)) {
          if (!$this->validaCPF($object->$attribute)) {
            $this->addError($object, $attribute, Yii::t('yii', '{attribute} é inválido.'));
          }
        }
    }

    public function clientValidateAttribute($object, $attribute)
    {
    }

    private function validaCNPJ($cnpj)
    {
        // Verifiva se o número digitado contém todos os digitos
        $cnpj = MGFormatter::numeroLimpo($cnpj);
        $cnpj = str_pad(preg_replace('/[^0-9_]/', '', $cnpj), 14, '0', STR_PAD_LEFT);
        // valida número sequencial 1111... 22222 ......
        for ($x=0; $x<10; $x++) {
            if ($cnpj == str_repeat($x, 14)) {
                return false;
            }
        }

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cnpj) != 14) {
            return false;
        } else {   // Calcula os números para verificar se o CNPJ é verdadeiro
            for ($t = 12; $t < 14; $t++) {
                $d = 0;
                $c = 0;
                for ($m = $t - 7; $m >= 2; $m--, $c++) {
                    $d += $cnpj{$c} * $m;
                }
                for ($m = 9; $m >= 2; $m--, $c++) {
                    $d += $cnpj{$c} * $m;
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cnpj{$c} != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    private function validaCPF($cpf)
    {
        // Verifiva se o número digitado contém todos os digitos
        $cpf = MGFormatter::numeroLimpo($cpf);
        $cpf = str_pad(preg_replace('/[^0-9_]/', '', $cpf), 11, '0', STR_PAD_LEFT);

        // valida número sequencial 1111... 22222 ......
        for ($x=0; $x<10; $x++) {
            if ($cpf == str_repeat($x, 11)) {
                return false;
            }
        }

        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11) {
            return false;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }
}
