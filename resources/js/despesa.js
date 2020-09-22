$(document).ready(function() {
    var wrapper = $(".form_container");
    var add_button = $(".add_form_fields");
    var x = 0;
    
    $(add_button).click(function(e) {
        e.preventDefault();
        x++;
        
        // Create new div
        var div = document.createElement("div");
        $(div)
            .attr("id", "new_expense_".concat(x.toString()))
            .appendTo(wrapper);
        
        // Create title
        $('<h3 />')
            .text('Tipo de despesa '.concat(x.toString()))
            .appendTo(div);
        
        // Create delete option
        var del_btn = document.createElement("a");
        $(del_btn)
            .attr("href", "#")
            .attr("class", "delete")
            .text("Remover")
            .appendTo(div);
        
        // Create name input
        var name_div = document.createElement("div");
        div.append(name_div);
        var name_id = "expense_name".concat(x.toString());
        
        $('<label />')
            .attr("for", name_id)
            .text("Nome: ")
            .appendTo(name_div);
        
        $('<input />')
            .attr("type", "text")
            .attr("name", name_id)
            .appendTo(name_div);

        // Create description input
        var desc_div = document.createElement("div");
        div.append(desc_div);
        var description_id = "expense_description".concat(x.toString());
        
        $('<label />')
            .attr("for", description_id)
            .text("Descrição: ")
            .appendTo(desc_div);
        
        $('<input />')
            .attr("type", "text")
            .attr("description", description_id)
            .appendTo(desc_div);
        
        // Create default input
        var defa_div = document.createElement("div");
        div.append(defa_div);
        var default_id = "expense_default".concat(x.toString());
        
        $('<label />')
            .attr("for", default_id)
            .text("Valor padrão: ")
            .appendTo(defa_div);
        
        $('<input />')
            .attr("type", "text")
            .attr("default", default_id)
            .appendTo(defa_div);
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).parent().remove();
    });
});