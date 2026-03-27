<?php

/**
 * @package   Duplicator
 * @copyright (c) 2022, Snap Creek LLC
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

/**
 * Variables
 *
 * @var bool $isOk
 * @var string $message
 * @var int $affectedTableCount
 * @var string[] $affectedTables
 */

$statusClass = $isOk ? 'green' : 'red';
?>
<div class="sub-title">STATUS</div>

<?php if (!$isOk) : ?>
    <p class="red">
        The chosen Database Action will result in the modification of <b><?php echo $affectedTableCount; ?></b>
        table(s).
    </p>
<?php else : ?>
    <p class="green">
        <?php if (InstState::isRestoreBackup()) : ?>
            Restore backup replace tables with the backup tables.
        <?php else : ?>
            The chosen Database Action does not affect any tables in the selected database.
        <?php endif; ?>
    </p>
<?php endif; ?>
<div class="sub-title">DETAILS</div>
<p><?php echo $message; ?></p>

<div class="s1-validate-flagged-tbl-list">
    <ul>
        <?php foreach ($affectedTables as $table) : ?>
        <li><?php echo htmlentities($table); ?></li>
        <?php endforeach; ?>
    </ul>
</div>

