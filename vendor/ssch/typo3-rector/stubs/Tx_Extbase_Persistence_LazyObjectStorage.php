<?php

namespace RectorPrefix20210613;

if (\class_exists('Tx_Extbase_Persistence_LazyObjectStorage')) {
    return;
}
class Tx_Extbase_Persistence_LazyObjectStorage
{
}
\class_alias('Tx_Extbase_Persistence_LazyObjectStorage', 'Tx_Extbase_Persistence_LazyObjectStorage', \false);