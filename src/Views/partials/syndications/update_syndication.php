<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
?>
<div class="modal fade" id="exampleModal" tabindex="-1" data-bs-backdrop="static"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modifier la syndication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mt-3" class="mb-5">
                    <div class="mb-3">
                        <label for="syndic_name" class="form-label">Nom de la syndication</label>
                        <input type="text" x-model="updatedSyndication.name" class="form-control"
                               id="syndic_name" placeholder="ex: Gîtes" required aria-required="true">
                    </div>
                    <div class="mb-3">
                        <label for="syndic_id" class="form-label">Identifiant de la syndication</label>
                        <input type="text" x-model="updatedSyndication.syndic_id" class="form-control"
                               id="syndic_id"
                               placeholder="ex: 335a0c75-1bb3-4835-9ed8-750c6890195c" required aria-required="true">
                    </div>
                    <div class="mb-3">
                        <label for="syndic_category" class="form-label">Catégorie à associer</label>
                        <select id="syndic_category" class="form-select"
                                x-model="updatedSyndication.category_id" required aria-required="true">
                            <option value="" disabled aria-disabled="true">--Veuillez choisir une option--</option>
                            <template x-for="category in categories">
                                <option x-text="category.name" :value="category.id" :selected="updatedSyndication.category_id == category.id"></option>
                            </template>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="associated_post_type" class="form-label">Type de contenu à associer</label>
                        <select id="associated_post_type" class="form-select"
                                x-model="updatedSyndication.associated_post_type" required aria-required="true">
                            <option value="" disabled aria-disabled="true">--Veuillez choisir une option--</option>
                            <template x-for="type in postTypes">
                                <option x-text="type.name" :value="type.slug" :selected="updatedSyndication.associated_post_type === type.slug"></option>
                            </template>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button @click.prevent="cancelSyndicationUpdate" class="btn btn-danger mt-3"
                                data-bs-dismiss="modal">Annuler
                        </button>
                        <button @click.prevent="updateSyndication" class="btn btn-primary mt-3" type="submit">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
