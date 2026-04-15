<?php

namespace App\Utils;

final class PixStaticFacade
{
    /**
     * ==============================
     * CONSTANTS (EMVCo / PIX IDS)
     * ==============================
     */

    const ID_PAYLOAD_FORMAT_INDICATOR = '00';               // Formato do payload (sempre '01' para Pix)
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';           // Informações da conta do recebedor
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';       // GUI (sempre 'br.gov.bcb.pix')
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';       // Chave Pix (CPF, e-mail, celular ou EVP)
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02'; // Descrição opcional do pagamento

    const ID_MERCHANT_CATEGORY_CODE = '52';                 // Código MCC (use '0000' para pessoa física)
    const ID_TRANSACTION_CURRENCY = '53';                   // Moeda (986 = BRL)
    const ID_TRANSACTION_AMOUNT = '54';                     // Valor da transação

    const ID_COUNTRY_CODE = '58';                           // País (BR)
    const ID_MERCHANT_NAME = '59';                          // Nome do recebedor (máx 25 caracteres)
    const ID_MERCHANT_CITY = '60';                          // Cidade do recebedor

    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';         // Dados adicionais (ex: TXID)
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';    // Identificador da transação

    const ID_CRC16 = '63';                                 // Campo de validação CRC16


    /**
     * ==============================
     * CALCULATE CRC16 (PIX REQUIRED)
     * ==============================
     *
     * Calcula o checksum CRC16 conforme padrão EMVCo.
     */
    private function calculateCRC16(string $payload): string
    {
        $polynomial = 0x1021;
        $result = 0xFFFF;

        for ($i = 0; $i < strlen($payload); $i++) {
            $result ^= (ord($payload[$i]) << 8);

            for ($j = 0; $j < 8; $j++) {
                if (($result & 0x8000) !== 0) {
                    $result = (($result << 1) ^ $polynomial);
                } else {
                    $result <<= 1;
                }

                $result &= 0xFFFF;
            }
        }

        return strtoupper(str_pad(dechex($result), 4, '0', STR_PAD_LEFT));
    }


    /**
     * ==============================
     * GENERATE PIX PAYLOAD
     * ==============================
     *
     * Gera o payload completo no padrão Pix (EMVCo).
     *
     * @param string $key        Chave Pix
     * @param string $name       Nome do recebedor
     * @param string $city       Cidade do recebedor
     * @param float|null $amount Valor da cobrança (opcional)
     * @param string $txid       Identificador da transação
     * @param string|null $description Descrição do pagamento
     *
     * @return string Payload Pix pronto para QR Code
     */
    public function generatePayload(
        string $key,
        string $name,
        string $city,
        ?float $amount = null,
        string $txid = '***',
        ?string $description = null
    ): string {

        // 00 - Payload Format Indicator
        $payload = self::ID_PAYLOAD_FORMAT_INDICATOR . '02' . '01';

        // 26 - Merchant Account Information
        $merchantAccount = self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI . '14' . 'br.gov.bcb.pix';
        $merchantAccount .= self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY
            . str_pad(strlen($key), 2, '0', STR_PAD_LEFT)
            . $key;

        if ($description) {
            $merchantAccount .= self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION
                . str_pad(strlen($description), 2, '0', STR_PAD_LEFT)
                . $description;
        }

        $payload .= self::ID_MERCHANT_ACCOUNT_INFORMATION
            . str_pad(strlen($merchantAccount), 2, '0', STR_PAD_LEFT)
            . $merchantAccount;

        // 52 - MCC
        $payload .= self::ID_MERCHANT_CATEGORY_CODE . '04' . '0000';

        // 53 - Currency (BRL)
        $payload .= self::ID_TRANSACTION_CURRENCY . '03' . '986';

        // 54 - Amount (optional)
        if ($amount !== null) {
            $formattedAmount = number_format($amount, 2, '.', '');

            $payload .= self::ID_TRANSACTION_AMOUNT
                . str_pad(strlen($formattedAmount), 2, '0', STR_PAD_LEFT)
                . $formattedAmount;
        }

        // 58 - Country
        $payload .= self::ID_COUNTRY_CODE . '02' . 'BR';

        // 59 - Name
        $payload .= self::ID_MERCHANT_NAME
            . str_pad(strlen($name), 2, '0', STR_PAD_LEFT)
            . $name;

        // 60 - City
        $payload .= self::ID_MERCHANT_CITY
            . str_pad(strlen($city), 2, '0', STR_PAD_LEFT)
            . $city;

        // 62 - Additional Data (TXID)
        $additionalData = self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID
            . str_pad(strlen($txid), 2, '0', STR_PAD_LEFT)
            . $txid;

        $payload .= self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE
            . str_pad(strlen($additionalData), 2, '0', STR_PAD_LEFT)
            . $additionalData;

        // 63 - CRC16
        $payload .= self::ID_CRC16 . '04'
            . $this->calculateCRC16($payload . self::ID_CRC16 . '04');

        return $payload;
    }
}