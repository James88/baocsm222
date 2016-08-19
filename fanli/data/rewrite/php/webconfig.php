<?php
include('../../../comm/dd.config.php');
include(DDROOT.'/comm/rewrite.class.php');
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?>';
$rule_name=1;
?>
<configuration>
    <system.webServer>
	    <rewrite>
            <rules>
                <?php
$rewrite = new rewrite();
echo $rewrite->run('web_config');
?>
            </rules>
        </rewrite> 
        <directoryBrowse enabled="false" />
        <defaultDocument>
            <files>
                <clear />
                <add value="index.php" />
                <add value="index.html" />
                <add value="Default.htm" />
                <add value="index.htm" />
            </files>
        </defaultDocument>
		<httpErrors>
            <remove statusCode="404" subStatusCode="-1" />
            <error statusCode="404" prefixLanguageFilePath="" path="/404.html" responseMode="ExecuteURL" />
        </httpErrors>
		<security> 
            <requestFiltering allowDoubleEscaping="true"></requestFiltering> 
        </security>
    </system.webServer>
</configuration>

<?php
$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/web.config',$c);
ob_clean();
?>