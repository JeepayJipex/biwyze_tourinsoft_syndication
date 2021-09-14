<div class="modal fade" id="addSyndicModal" tabindex="-1" data-bs-backdrop="static"
     aria-labelledby="addSyndicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSyndicModalLabel">Ajouter une syndication</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mt-3">
                    <div class="mb-3">
                        <label for="add_syndic_name" class="form-label">Nom de la syndication</label>
                        <input type="text" x-model="newSyndication.name" class="form-control" id="add_syndic_name"
                               placeholder="ex: Gîtes" required aria-required="true">
                    </div>
                    <div class="mb-3">
                        <label for="add_syndic_nameid" class="form-label">Identifiant de la syndication</label>
                        <input type="text" x-model="newSyndication.syndic_id" class="form-control"
                               id="add_syndic_nameid"
                               placeholder="ex: 335a0c75-1bb3-4835-9ed8-750c6890195c" required aria-required="true">
                    </div>
                    <div class="mb-3">
                        <label for="add_syndic_category" class="form-label">Catégorie à associer</label>
                        <select id="add_syndic_category" class="form-select" x-model="newSyndication.category_id" required aria-required="true">
                            <option value="" disabled aria-disabled="true">--Veuillez choisir une option--</option>
                            <template x-for="category in categories">
                                <option x-text="category.name" :value="category.id"></option>
                            </template>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="add_associated_post_type" class="form-label">Type de contenu à associer</label>
                        <select id="add_associated_post_type" class="form-select"
                                x-model="newSyndication.associated_post_type" required aria-required="true">
                            <option value="" disabled aria-disabled="true">--Veuillez choisir une option--</option>
                            <template x-for="type in postTypes">
                                <option x-text="type.name" :value="type.slug"></option>
                            </template>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-danger mt-3" type="button"
                                data-bs-dismiss="modal">Annuler
                        </button>
                        <button @click.prevent="createSyndication" type="button" class="btn btn-primary mt-3">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
