<?php

namespace RectorPrefix20210613;

if (\class_exists('SC_tce_db')) {
    return;
}
class SC_tce_db
{
}
\class_alias('SC_tce_db', 'SC_tce_db', \false);