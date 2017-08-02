<?php
/**
 * @var bool $activeStep
 */
?>
<div class="row bs-wizard" style="border-bottom:0;">
    <div class="col-xs-4 bs-wizard-step <?= $activeStep == 1 ? 'active' : ( $activeStep > 1 ? 'complete' : 'disabled' ) ?>">
        <div class="text-center bs-wizard-stepnum">Step 1. Ruleset</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
        <span class="bs-wizard-dot"></span>
        <div class="bs-wizard-info text-center">Create rules for parsing leadgen form.</div>
    </div>

    <div class="col-xs-4 bs-wizard-step <?= $activeStep == 2 ? 'active' : ( $activeStep > 2 ? 'complete' : 'disabled' ) ?>"><!-- complete -->
        <div class="text-center bs-wizard-stepnum">Step 2. Connection</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
        <span class="bs-wizard-dot"></span>
        <div class="bs-wizard-info text-center">Create connection for certain destination.</div>
    </div>

    <div class="col-xs-4 bs-wizard-step <?= $activeStep == 3 ? 'active' : ( $activeStep > 3 ? 'complete' : 'disabled' ) ?>"><!-- complete -->
        <div class="text-center bs-wizard-stepnum">Step 3. Done</div>
        <div class="progress">
            <div class="progress-bar"></div>
        </div>
        <span class="bs-wizard-dot"></span>
        <div class="bs-wizard-info text-center">System will check for leads.</div>
    </div>
</div>