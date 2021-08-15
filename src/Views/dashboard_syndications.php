<?php
?>
<div x-data="syndications">
    <form class="mt-3">
        <h4 class="mb-4">Ajouter une syndication</h4>
        <div class="mb-3">
            <label for="syndic_name" class="form-label">Nom de la syndication</label>
            <input type="text" x-model="newSyndication.name" class="form-control" id="syndic_name"
                   placeholder="ex: Gîtes">
        </div>
        <div class="mb-3">
            <label for="syndic_name" class="form-label">Identifiant de la syndication</label>
            <input type="text" x-model="newSyndication.syndic_id" class="form-control" id="syndic_name"
                   placeholder="ex: 335a0c75-1bb3-4835-9ed8-750c6890195c">
        </div>
        <div class="mb-3">
            <label for="syndic_category" class="form-label">Catégorie à associer</label>
            <select id="syndic_category" class="form-select" x-model="newSyndication.category_id">
                <template x-for="category in categories">
                    <option x-text="category.name" :value="category.id"></option>
                </template>
            </select>
        </div>

        <button @click.prevent="createSyndication" class="btn btn-primary mt-3">Ajouter</button>
    </form>

    <hr class="my-5"/>
    <h4 class="mb-4">Vos syndications</h4>

    <div class="list-group mb-3">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Identifiant</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr id="update-syndication" x-show="updating" >
                <td colspan="5">
                    <form class="mt-3" class="mb-5">
                        <h4 class="mb-4">Modifier la syndication</h4>
                        <div class="mb-3">
                            <label for="syndic_name" class="form-label">Nom de la syndication</label>
                            <input type="text" x-model="updatedSyndication.name" class="form-control"
                                   id="syndic_name" placeholder="ex: Gîtes">
                        </div>
                        <div class="mb-3">
                            <label for="syndic_name" class="form-label">Identifiant de la syndication</label>
                            <input type="text" x-model="updatedSyndication.syndic_id" class="form-control"
                                   id="syndic_name"
                                   placeholder="ex: 335a0c75-1bb3-4835-9ed8-750c6890195c">
                        </div>
                        <div class="mb-3">
                            <label for="syndic_category" class="form-label">Catégorie à associer</label>
                            <select id="syndic_category" class="form-select"
                                    x-model="updatedSyndication.category_id">
                                <template x-for="category in categories">
                                    <option x-text="category.name" :value="category.id"></option>
                                </template>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end mb-5">
                            <button @click.prevent="cancelSyndicationUpdate" class="btn btn-danger mt-3">Annuler
                            </button>
                            <button @click.prevent="updateSyndication" class="btn btn-primary mt-3">Modifier</button>
                        </div>
                    </form>
                </td>
            </tr>
            <template x-for="syndication in syndications">
                <tr>
                    <th scope="row" x-text="syndication.id"></th>
                    <td x-text="syndication.name"></td>
                    <td x-text="syndication.syndic_id"></td>
                    <td x-text-="getCategoryName(syndication.category_id)"></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-info"
                                    @click.prevent="startSyndicationUpdate(syndication)">Modifier
                            </button>
                            <button type="button" class="btn btn-danger"
                                    @click.prevent="deleteSyndication(syndication.id)">Supprimer
                            </button>
                        </div>
                    </td>
                </tr>

            </template>
            </tbody>
        </table>
    </div>
</div>
<?php ?>
