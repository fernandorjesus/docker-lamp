<?php

/**
 * @package   Duplicator
 * @copyright (c) 2022, Snap Creek LLC
 */

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

/**
 * Variables
 *
 * @var bool $isOk
 * @var bool $dbExcluded
 */

$statusClass = $isOk ? 'green' : 'red';
?>
<div class="sub-title">STATUS</div>
<p class="<?php echo $statusClass; ?>">
    <?php if ($dbExcluded) { ?>
        The database was excluded from the package during build.
    <?php } ?>

    <?php if ($isOk) { ?>
        The installer is going to perform all database actions.
    <?php } else { ?>
        The installer is going to skip any actions it would usually perform on the database, and act as a smart file extractor.
    <?php } ?>
</p>

<div class="sub-title">DETAILS</div>
<p>
    This test checks whether the "Extract Only Files" database action was selected or the database as excluded from the package during build and adjusts
    the installer parameters accordingly. When the database is excluded, there is no need for Database credentials.
</p>



