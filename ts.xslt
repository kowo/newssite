<?xml version="1.0" encoding="UTF-8" ?>

<xsl:stylesheet version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  xmlns:atom="http://www.w3.org/2005/Atom" 
  exclude-result-prefixes="atom">

  <xsl:output method="html" encoding="utf-8" indent="yes" omit-xml-declaration="yes" />

  <xsl:template match="atom:feed">
    <xsl:text disable-output-escaping="yes">&lt;!DOCTYPE HTML SYSTEM "about:legacy-compat"></xsl:text>
    <html>
    <head><title>News Site</title>
    <style type="text/css">
      @import url('./style.css');
    </style>
    </head>
    <body>

    <xsl:call-template name="backlink" />
    <xsl:call-template   name="top" />
    <xsl:call-template name="feedlink" />
    <xsl:apply-templates select="atom:entry" />

    </body>
    </html>

  </xsl:template>

  <!-- Newseintrag -->
  <xsl:template match="atom:entry">
    <xsl:element name="div">
      <xsl:element name="h3">
        <xsl:element name="a">
          <xsl:attribute name="href">
            <xsl:value-of select="atom:id" />
          </xsl:attribute>
          <xsl:attribute name="target">_blank</xsl:attribute>
          <xsl:value-of select="atom:title" />
        </xsl:element>
      </xsl:element>

      <xsl:element name="h6">
        <xsl:value-of select="atom:updated" />
      </xsl:element>

      <xsl:element name="p">
        <xsl:value-of select="atom:summary" />
      </xsl:element>
    </xsl:element>
  </xsl:template>
  
  <!-- Heading -->
  <xsl:template name="top">
    <h2>
      <xsl:element name="a">
        <xsl:attribute name="href">
          <xsl:value-of select="./atom:link/@href" />
        </xsl:attribute>
        <xsl:value-of select="atom:title" />
      </xsl:element>
    </h2>
    <h3>
      <xsl:value-of select="atom:subtitle" />
    </h3>
    <h6>
      <xsl:value-of select="atom:updated" />
    </h6>
  </xsl:template>

  <!-- Link zum original Feed -->
  <xsl:template name="feedlink">
    <xsl:for-each select="./atom:link">
      <xsl:if test="./@rel">
        <xsl:element name="a">
          <xsl:attribute name="href">
            <xsl:value-of select="./@href" />
          </xsl:attribute>
          Atom Feed
        </xsl:element>
      </xsl:if>
    </xsl:for-each>
  </xsl:template>

  <!-- Link zur Startseite -->
  <xsl:template name="backlink">
    <xsl:element name="a">
      <xsl:attribute name="href">
        <xsl:text>./index.php</xsl:text>
      </xsl:attribute>
      Zur Startseite
    </xsl:element>
  </xsl:template>


</xsl:stylesheet>