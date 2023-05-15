<?php

namespace PaperAlliance;

/**
 * JaneNameEnum Class Doc Comment
 * @category    Class
 * @description 系统名称&lt;br&gt; wanfang：万方&lt;br&gt; cnkivip：知网VIP&lt;br&gt; cnkipmlc：知网大学生系统&lt;br&gt; cnkiamlc：知网期刊&lt;br&gt; cnkisaml：知网大分解&lt;br&gt; cnkijmlc：知网学位版&lt;br&gt; cqvip：维普 &lt;br&gt;..
 */
class JaneNameEnum
{
    /**
     * Possible values of this enum
     */
    const ZJCHONG = 'zjchong';
    const WANFANG = 'wanfang';
    const WANFANGGl = 'wanfanggl';
    const WANFANGBD = 'wanfangbd';
    const WANFANGMD = 'wanfangmd';
    const WANFANGPA = 'wanfangpa';
    const CHECKPASS = 'checkpass';
    const CNKIVIP = 'cnkivip';
    const CNKIPMLC = 'cnkipmlc';
    const CNKIAMLC = 'cnkiamlc';
    const CNKISAMLC = 'cnkisamlc';
    const CNKIFENJIE="cnkifenjie";
    const CNKIJMLC = 'cnkijmlc';
    const PAPERPASS = 'paperpass';
    const GOCHECK = 'gocheck';
    const CQVIP = 'cqvip';
    const TURNITIN = 'turnitin';
    const TURNITINUK = 'turnitinuk';
    const ITHENTICATE = 'ithenticate';
    const PAPERYY = 'paperyy';
    const PAPERRATER = 'paperrater';
    const CNKITPMLC = 'cnkitpmlc';
    const CNKITVIP = 'cnkitvip';

    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::ZJCHONG,
            self::WANFANG,
            self::WANFANGGl,
            self::WANFANGBD,
            self::WANFANGMD,
            self::WANFANGPA,
            self::CHECKPASS,
            self::CNKIVIP,
            self::CNKIPMLC,
            self::CNKIAMLC,
            self::CNKISAMLC,
            self::CNKIFENJIE,
            self::CNKIJMLC,
            self::PAPERPASS,
            self::GOCHECK,
            self::CQVIP,
            self::TURNITIN,
            self::TURNITINUK,
            self::ITHENTICATE,
            self::PAPERYY,
            self::PAPERRATER,
            self::CNKITPMLC,
            self::CNKITVIP,
        ];
    }
}


