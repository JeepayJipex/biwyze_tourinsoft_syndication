<div class="modal fade" id="previewSyndicModal" aria-hidden="true" aria-labelledby="" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Détails de la syndication "<span
                            x-text="getCurrentSyndicationName()"></span>"</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                Offres
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p><span x-text="getCurrentSyndicationOffers().length"></span> offre(s)
                                    disponible(s)</p>
                                <div class="list-group">
                                    <template x-for="offer in getCurrentSyndicationOffers()">
                                        <button type="button" class="list-group-item list-group-item-action"
                                                x-text="offer.SyndicObjectName"></button>
                                        <br/>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Champs disponibles
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse " aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <p><span x-text="getCurrentSyndicationFields().length"></span> champ(s) configuré(s)
                                </p>
                                <div class="list-group">
                                    <template x-for="field in getCurrentSyndicationFields()">
                                        <button type="button" class="list-group-item list-group-item-action"
                                                x-text="field"></button>
                                        <br/>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false"
                                    aria-controls="collapseThree">
                                Contenu du lien
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                     <textarea class="form-control" id="syndicationContent" rows="10" disabled
                                               x-text="currentSyndication.content"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
