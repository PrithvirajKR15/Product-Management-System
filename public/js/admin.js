function addAttributeRow() {
    const attributesContainer = $('#attributesContainer');
    if (attributesContainer.length) {
        const htmlString = `
            <div class="attribute-row">
                <div class="attribute-input-group">
                    <input 
                        type="text" 
                        name="attribute_key[]" 
                        class="form-input attribute-key" 
                        placeholder="Key (e.g., Size, Color)"
                    >
                    <input 
                        type="text" 
                        name="attribute_value[]" 
                        class="form-input attribute-value" 
                        placeholder="Value (e.g., Large, Red)"
                    >
                    <button type="button" onclick="removeAttributeRow(this)" class="btn btn-danger btn-sm remove-attribute remove-attribute-hidden">Remove</button>
                </div>
            </div>
        `;
        attributesContainer.append(htmlString);
        updateRemoveButtons();
    }
}

function removeAttributeRow(button) {
    const $button = $(button);
    const attributeRow = $button.closest('.attribute-row');
    if (attributeRow.length) {
        attributeRow.remove();
        updateRemoveButtons();
    }
}

function updateRemoveButtons() {
    const attributeRows = $('.attribute-row');
    const removeButtons = $('.remove-attribute');
    
    if (attributeRows.length > 1) {
        removeButtons.removeClass('remove-attribute-hidden');
    } else {
        removeButtons.addClass('remove-attribute-hidden');
    }
}

$(document).ready(function() {
    updateRemoveButtons();
});

