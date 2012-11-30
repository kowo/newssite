<?xml version="1.0" encoding="UTF-8" ?>

<xsl:stylesheet version="1.0" 
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

  <xsl:output method="html" encoding="utf-8" indent="yes" omit-xml-declaration="yes" />

  <xsl:template match="/rss/channel">
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
    <xsl:apply-templates select="item" />

    </body>
    </html>

  </xsl:template>

  <!-- Newseintrag -->
  <xsl:template match="item">
    <xsl:element name="div">
      <xsl:element name="h3">
        <xsl:element name="a">
          <xsl:attribute name="href">
            <xsl:value-of select="link" />
          </xsl:attribute>
          <xsl:attribute name="target">_blank</xsl:attribute>
          <xsl:value-of select="title" />
        </xsl:element>
      </xsl:element>

      <xsl:element name="h6">
        <xsl:value-of select="pubDate" />
      </xsl:element>

      <xsl:element name="p">
        <xsl:value-of select="description" />
      </xsl:element>
    </xsl:element>
  </xsl:template>
  
  <!-- Heading -->
  <xsl:template name="top">
    <h2>
      <xsl:element name="a">
        <xsl:attribute name="href">
          <xsl:value-of select="./link" />
        </xsl:attribute>
        <xsl:value-of select="title" />
      </xsl:element>
    </h2>
    <xsl:element name="img">
      <xsl:attribute name="src">
        <xsl:value-of select="./image/url" />
      </xsl:attribute>
      <xsl:attribute name="alt">
        <xsl:value-of select="./image/title" />
      </xsl:attribute>
    </xsl:element>
    <h6>
      <xsl:value-of select="lastBuildDate" />
    </h6>

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