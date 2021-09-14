<?php
?>
<div x-data="syndications">

<?php
include(__DIR__ . '/partials/syndications/add_syndication.php');
include(__DIR__ . '/partials/syndications/update_syndication.php');
include(__DIR__ . '/partials/syndications/show_syndication.php');
?>

    <!--    SYNDICATIONS   -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h4 class="mb-4">Vos syndications</h4>
        <div>
            <button x-bind:disabled="$store.main.loading"
                    type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addSyndicModal">Ajouter une syndication
            </button>
            <button x-bind:disabled="$store.main.loading"
                    type="button" class="btn btn-secondary btn-sm" @click.prevent="syncAll">Tout synchroniser
            </button>
        </div>
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
                            <button type="button" class="btn btn-outline-info btn-sm"
                                    data-toggle="tooltip" data-placement="bottom" title="Voir les détails"
                                    x-bind:disabled="$store.main.loading"
                                    @click.prevent="getCurrentSyndication(syndication.id)" data-bs-toggle="modal"
                                    data-bs-target="#previewSyndicModal"><span
                                        class="dashicons dashicons-visibility"></span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm"
                                    data-toggle="tooltip" data-placement="bottom" title="Modifier"
                                    @click.prevent="startSyndicationUpdate(syndication)" data-bs-toggle="modal"
                                    x-bind:disabled="$store.main.loading"
                                    data-bs-target="#exampleModal"><span class="dashicons dashicons-edit"></span>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm"
                                    data-toggle="tooltip" data-placement="bottom" title="Supprimer"
                                    x-bind:disabled="$store.main.loading"
                                    @click.prevent="deleteSyndication(syndication.id)"><span
                                        class="dashicons dashicons-trash"></span>
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                    data-toggle="tooltip" data-placement="bottom" title="Importer les offres"
                                    x-bind:disabled="$store.main.loading"
                                    @click.prevent="syncOne(syndication.id)"><span
                                        class="dashicons dashicons-image-rotate"></span>
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
