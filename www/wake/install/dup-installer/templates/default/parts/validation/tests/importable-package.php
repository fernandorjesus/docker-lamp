<?php

/**
 * @package   Duplicator
 * @copyright (c) 2022, Snap Creek LLC
 */

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

/**
 * Variables
 *
 * @var int      $testResult  validation rest result enum
 * @var string[] $failMessages fail message
 */

$statusClass = ($testResult > DUPX_Validation_abstract_item::LV_SOFT_WARNING ? 'green' : 'maroon' );
?>
<div class="sub-title">STATUS</div>
<p class="<?php echo $statusClass; ?>">
    <?php if ($testResult > DUPX_Validation_abstract_item::LV_SOFT_WARNING) { ?>
        The package has all the elements to be imported.
    <?php } else { ?>
        You are importing a <b>partial package</b>.<br>
        A package with filtered elements could cause a malfunction of the current site.
    <?php } ?>
</p>

<?php if (count($failMessages) > 0) { ?>
    <div class="sub-title">DETAILS</div>
    <ul>
        <?php foreach ($failMessages as $failMessage) { ?>
            <li><?php echo $failMessage; ?></li>
        <?php } ?>
    </ul>
<?php } ?>

<div class="sub-title">TROUBLESHOOT</div>
<ul>
    <li>
        The package can be installed, only the files in the package will be overwritten, make sure they are compatible with the current website.
    </li>
</ul>
