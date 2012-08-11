<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:php="http://php.net/xsl"
                exclude-result-prefixes="php">
    <!--  omit-xml-declaration="yes"  -->
    <xsl:output method="text" xml:lang="en" indent="no"
                encoding="UTF-8"/>

    <xsl:variable name="tab" select="'&#9;'"/>
    <xsl:variable name="spacer" select="'&#160;'"/>
    <xsl:variable name="hr"
                  select="'&#xA;_ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _ _&#xA;'"/>
    <xsl:variable name="li" select="'&#xA;&#9;'"/>
    <xsl:variable name="quote"
                  select="'QUOTE: &#xA;++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++&#xA;'"/>
    <xsl:variable name="endquote"
                  select="'&#xA;++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++&#xA;END QUOTE&#xA;'"/>

    <xsl:variable name="lf" select="'&#xA;'"/>
    <xsl:variable name="td" select="'|&#9;'"/>
    <xsl:variable name="lf2" select="'&#xA;&#xA;'"/>
    <xsl:variable name="p" select="'&#xA;&#xA;&#9;'"/>
    <xsl:variable name="cr" select="'&#13;'"/>

    <xsl:strip-space elements="*"/>
    <xsl:preserve-space elements="pre"/>

    <xsl:namespace-alias stylesheet-prefix="php"
                         result-prefix="xsl"/>


    <xsl:template match="/">
        <xsl:element name="plaintext">
            <xsl:apply-templates/>
        </xsl:element>
    </xsl:template>


    <xsl:template match="text()">
        <xsl:value-of select="normalize-space(.)"/>
    </xsl:template>


    <!-- elements that we want to completely drop -->
    <xsl:template
            match="head|script|object|embed|video|form|button|select|option|style"/>
    <!-- // elements to drop -->

    <xsl:template match="p">
        <xsl:value-of select="$p"/>
        <xsl:apply-templates/>
        <xsl:value-of select="$lf2"/>
    </xsl:template>

    <xsl:template match="h1">
        <xsl:value-of select="$p"/>
        <!-- <xsl:text> # </xsl:text> -->
        <xsl:value-of select="normalize-space(php:function('strtoupper', string(.)))"/>
        <xsl:apply-templates/>
        <!-- <xsl:text> # </xsl:text> -->
        <xsl:value-of select="$lf"/>
    </xsl:template>


    <xsl:template match="h2">
        <xsl:value-of select="$p"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="normalize-space(php:function('strtoupper', string(.)))"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="$lf"/>
    </xsl:template>


    <xsl:template match="h3|h4|h5|h6">
        <xsl:value-of select="$p"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="normalize-space(php:function('ucwords', string(.)))"/>
        <xsl:text> </xsl:text>
        <xsl:value-of select="$lf"/>
    </xsl:template>

    <xsl:template match="br">
        <xsl:value-of select="$lf"/>
    </xsl:template>

    <xsl:template match="div|span">
        <xsl:value-of select="$lf"/>
        <xsl:apply-templates/>
    </xsl:template>

    <xsl:template match="i|em">
        <xsl:text> </xsl:text>
        <xsl:text>_</xsl:text>
        <xsl:apply-templates/>
        <xsl:text>_</xsl:text>
        <xsl:text> </xsl:text>
    </xsl:template>

    <xsl:template match="b|strong|big">
        <xsl:text> </xsl:text>
        <!-- <xsl:value-of select="php:function('strtoupper', string(.))" />  -->
        <xsl:text>**</xsl:text>
        <xsl:apply-templates/>
        <xsl:text>**</xsl:text>
        <xsl:text> </xsl:text>
    </xsl:template>

    <xsl:template match="ul">
        <xsl:value-of select="$lf"/>
        <xsl:for-each select="./li">
            <xsl:value-of select="$li"/>
            <xsl:text>* </xsl:text>
            <xsl:apply-templates/>
        </xsl:for-each>
        <xsl:value-of select="$lf"/>
    </xsl:template>


    <xsl:template match="ol">
        <xsl:value-of select="$lf"/>
        <xsl:for-each select="./li">
            <xsl:value-of select="$li"/>
            <xsl:value-of select="concat(position(), ') ')"/>
            <xsl:apply-templates/>
        </xsl:for-each>
        <xsl:value-of select="$lf"/>
    </xsl:template>


    <xsl:template match="hr">
        <xsl:value-of select="$hr"/>
    </xsl:template>

    <xsl:template match="a">
        <xsl:choose>
            <xsl:when
                    test="starts-with(./@href, 'http') or starts-with(./@href, 'ftp')">
                <xsl:value-of select="normalize-space(.)"/>
                <xsl:text> [Link: </xsl:text>
                <xsl:value-of select="./@href"/>
                <xsl:text> ] </xsl:text>
            </xsl:when>
            <xsl:otherwise>
                <xsl:text> </xsl:text>
                <xsl:apply-templates/>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>


    <xsl:template match="img">
        <xsl:if test="starts-with(./@src, 'http')">
            <xsl:text> [IMAGE:  </xsl:text>
            <xsl:value-of select="./@src"/>
            <xsl:text> ] </xsl:text>
        </xsl:if>
    </xsl:template>

    <xsl:template match="blockquote|cite">
        <xsl:value-of select="$quote"/>
        <xsl:apply-templates/>
        <xsl:value-of select="$endquote"/>
    </xsl:template>


    <xsl:template match="table">
        <xsl:apply-templates/>
        <xsl:value-of select="$lf"/>
    </xsl:template>

    <xsl:template match="tr">
        <xsl:value-of select="$hr"/>
        <xsl:apply-templates select="td|th"/>
        <xsl:value-of select="$tab"/>
        <xsl:text>|</xsl:text>
    </xsl:template>

    <xsl:template match="td">
        <xsl:variable name="ret">
            <xsl:value-of select="$td"/>
            <xsl:apply-templates/>
            <xsl:value-of select="$tab"/>
        </xsl:variable>
        <xsl:value-of select="normalize-space($ret)"/>
    </xsl:template>


    <xsl:template match="th">
        <xsl:variable name="ret">
            <xsl:value-of select="$td"/>
            <xsl:value-of select="php:function('strtoupper', string(.))"/>
            <xsl:value-of select="$tab"/>
        </xsl:variable>
        <xsl:value-of select="normalize-space($ret)"/>
    </xsl:template>

    <!-- removes spaces, tabs, line feeds from string -->
    <xsl:template name="removeSpaces">
        <xsl:param name="str"/>
        <xsl:value-of select="translate($str, ' &#x9;,&#xa;&#xd;,&#13;', '')"/>
    </xsl:template>
    <!-- // removes spaces -->

</xsl:stylesheet>