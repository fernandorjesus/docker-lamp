<?php

namespace Smashballoon\Customizer\V2;

interface PreviewProvider{
    public function render($attr, $settings);
}