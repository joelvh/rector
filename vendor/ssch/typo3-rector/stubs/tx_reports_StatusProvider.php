<?php

namespace RectorPrefix20210724;

if (\class_exists('tx_reports_StatusProvider')) {
    return;
}
class tx_reports_StatusProvider
{
}
\class_alias('tx_reports_StatusProvider', 'tx_reports_StatusProvider', \false);
