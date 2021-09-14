<div x-data="importExport">
    <h5 class="mb-3">Importer une sauvegarde</h5>
    <div class="mb-3">
        <label for="importArea" class="form-label">Coller le contenu à importer</label>
        <textarea class="form-control" id="importArea" rows="3" x-model="importString"></textarea>
    </div>
    <button type="button" @click="launchImport('string')" class="btn btn-primary mb-3">Importer les données</button>
<!--    <div class="mb-3">-->
<!--        <label for="formFile" class="form-label">Fichier à importer</label>-->
<!--        <input class="form-control" type="file" id="formFile" accept="application/JSON" x-model="importData">-->
<!--    </div>-->
<!--    <button type="button" @click="launchImport('file')" class="btn btn-primary mb-3">Importer le fichier</button>-->
<hr class="mb-3">
    <h5 class="mb-3">Exporter une sauvegarde</h5>
    <button type="button" @click="generateExport" class="btn btn-primary">Générer la sauvegarde</button>
    <template x-if="exportData !== null">
        <div class="mb-3">
            <label for="exportArea" class="form-label">Contenu exporté</label>
            <textarea class="form-control" id="exportArea" rows="10" x-model="exportParsed" disabled></textarea>
        </div>
    </template>
</div>