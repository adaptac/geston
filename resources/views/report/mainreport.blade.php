<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        
    </style>


</head>

<body>

    
		<div id="header">

            <table>
                <tr>
                    <td style="margin-left:0; width:1.9cm;">

                        <img src="{{ $_ENV['COMPANY_LOGO'] }} ?>">

                    </td>
                    <td style="padding: 0px; vertical-align: top; margin-bottom: 1cm; margin-left:0;">

                        <ul style="color:#000; font-size: 8pt;text-align:left; margin-left:0; padding:0; margin-top:0;">
                            
                            <li> {{ $_ENV['COMPANY_NAME'] }}</li>
                            <li> {{ $_ENV['COMPANY_LOCATION'] }} </li>
                            <li> {{ $_ENV['COMPANY_ADDRESS'] }} </li>
                            <li>Tel.: {{ $_ENV['COMPANY_TELEPHONE'] }}  Fax: {{ $_ENV['COMPANY_TELEFAX'] }}</li>
                            <li>NUIT:{{ $_ENV['COMPANY_NUIT'] }}</li>
                            <li>Data:<?php //echo date('Y-m-d h:m:sa') . ' ' ?>:<?php //echo ' Ref.: REC' . str_pad(34, 4, '0', STR_PAD_LEFT) ?></li>

                       </ul>

                    </td>
                </tr>
            </table>

        </div>


</body>
</html>
