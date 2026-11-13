<dialog class="tm-template-dialog" data-export-template-dialog>
    <form method="dialog"><h2>Export to Template</h2>
        <label for="export-template">Stored template</label>
        <select id="export-template" class="form-control">
            @foreach(app(\App\Services\TrademarkExport::class)->templates() as $id => $template)
            <option value="{{ $id }}">{{ $template['name'] }}</option>
            @endforeach
        </select>
        <p>Template management will be available in a future update.</p>
        <div><button class="btn" value="cancel">Cancel</button><button class="btn" type="button" data-template-export>Export</button></div>
    </form>
</dialog>
