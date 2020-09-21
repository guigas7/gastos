$(document).ready(function() {
    var wrapper = $(".form_container");
    var add_button = $(".add_form_fields");
    var x = 0;
    
    $(add_button).click(function(e) {
        var empty_div;
        e.preventDefault();
        x++;
        
        // Create new div
        var div = document.createElement("div");
        div.setAttribute("id", "new_expense_".concat(x.toString()));
        wrapper.append(div);
        
        // Create title
        var title = document.createElement("h3");
        title.innerText = 'Tipo de despesa '.concat(x.toString());
        div.append(title);
        
        // Create delete option
        var del_btn = document.createElement("a");
        del_btn.setAttribute("href", "#");
        del_btn.setAttribute("class", "delete");
        del_btn.innerText = "Remover";
        div.append(del_btn);
        
        // Create name input
        empty_div = document.createElement("div");
        div.append(empty_div);
        var name_id = "expense_name".concat(x.toString());
        
        var name_label = document.createElement("label");
        name_label.setAttribute("for", name_id);
        name_label.innerText = "Nome: ";
        empty_div.append(name_label);
        
        var name_input = document.createElement("input");
        name_input.setAttribute("type", "text");
        name_input.setAttribute("name", name_id);
        empty_div.append(name_input);

        // Create description input
        empty_div = document.createElement("div");
        div.append(empty_div);
        var description_id = "expense_description".concat(x.toString());
        
        var description_label = document.createElement("label");
        description_label.setAttribute("for", description_id);
        description_label.innerText = "Descrição: ";
        empty_div.append(description_label);
        
        var description_input = document.createElement("input");
        description_input.setAttribute("type", "text");
        description_input.setAttribute("description", description_id);
        empty_div.append(description_input);
        
        // Create default input
        empty_div = document.createElement("div");
        div.append(empty_div);
        var default_id = "expense_default".concat(x.toString());
        
        var default_label = document.createElement("label");
        default_label.setAttribute("for", default_id);
        default_label.innerText = "Valor padrão: ";
        empty_div.append(default_label);
        
        var default_input = document.createElement("input");
        default_input.setAttribute("type", "text");
        default_input.setAttribute("default", default_id);
        empty_div.append(default_input);
    });

    $(wrapper).on("click", ".delete", function(e) {
        e.preventDefault();
        $(this).siblings().remove();
        $(this).remove();
    });
});