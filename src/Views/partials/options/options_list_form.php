<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div x-data="options" class="py-5 d-flex flex-column align-items-start">
    <h5 class="mb-3 mb-3">Configuration de l'extension</h5>
    <template x-for="option in optionsList">
        <div class="mt-3">
            <template x-if="option.type === 'boolean'">
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" :value="getBooleanValue(option.value)"
                           x-model="option.value" :id="option.identifier">
                    <label class="form-check-label" :for="option.identifier" x-text="option.label">
                    </label>
                </div>
            </template>
            <template x-if="option.type === 'input'">
                <div class="mb-3">
                    <label :for="option.identifier" class="form-label" x-text="option.label"></label>
                    <input :type="option.input" class="form-control" :id="option.identifier" :value="option.value"
                           x-model="option.value" placeholder="name@example.com">
                </div>
            </template>
            <template x-if="option.type === 'select'">
                <div class="mb-3">
                    <label :for="option.identifier" class="form-label" x-text="option.label"></label>
                    <select class="form-select" aria-label="Default select example" :id="option.identifier"
                            x-model="option.value">
                        <template x-for="value in option.options">
                            <option :value="value" x-text="value" :selected="option.value === value"></option>
                        </template>
                    </select>
                </div>
            </template>
        </div>
    </template>
    <button @click.prevent="saveOptions" type="button" class="btn btn-primary mt-3 align-self-start">
        Sauvegarder les options
    </button>
</div>