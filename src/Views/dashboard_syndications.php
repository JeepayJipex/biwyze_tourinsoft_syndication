<?php
?>
<div x-data="syndications">

<!--    MODALS   -->
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
                        <div class="mb-3">
                            <label for="associated_post_type" class="form-label">Type de contenu à associer</label>
                            <select id="associated_post_type" class="form-select"
                                    x-model="newSyndication.associated_post_type">
                                <template x-for="type in postTypes">
                                    <option x-text="type.name" :value="type.slug"></option>
                                </template>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-danger mt-3" type="button"
                                    data-bs-dismiss="modal">Annuler
                            </button>
                            <button @click.prevent="createSyndication" type="button" class="btn btn-primary mt-3">Ajouter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="mb-3">
                            <label for="associated_post_type" class="form-label">Type de contenu à associer</label>
                            <select id="associated_post_type" class="form-select"
                                    x-model="updatedSyndication.associated_post_type">
                                <template x-for="type in postTypes">
                                    <option x-text="type.name" :value="type.slug"></option>
                                </template>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button @click.prevent="cancelSyndicationUpdate" class="btn btn-danger mt-3"
                                    data-bs-dismiss="modal">Annuler
                            </button>
                            <button @click.prevent="updateSyndication" class="btn btn-primary mt-3">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--    END MODALS   -->

<!--    SYNDICATIONS   -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="mb-4">Vos syndications</h4>
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#addSyndicModal">Ajouter une syndication
        </button>
    </div>




    <div class="list-group mb-3">
        <table class="table table-stripped table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nom</th>
                <th scope="col">Identifiant</th>
                <th scope="col">Catégorie</th>
                <th scope="col">Type de contenu</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <template x-for="syndication in syndications">
                <tr>
                    <th scope="row" x-text="syndication.id"></th>
                    <td x-text="syndication.name"></td>
                    <td x-text="syndication.syndic_id"></td>
                    <td x-text-="getCategoryName(syndication.category_id)"></td>
                    <td x-text-="getPostTypeName(syndication.associated_post_type)"></td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    @click.prevent="startSyndicationUpdate(syndication)" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">Modifier
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                    @click.prevent="deleteSyndication(syndication.id)">Supprimer
                            </button>
                        </div>
                    </td>
                </tr>

            </template>
            </tbody>
        </table>
    </div>
<!--    END SYNDICATIONS   -->
</div>
<?php ?>
