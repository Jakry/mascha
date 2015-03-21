$(document).ready(function() {	
	$('body').append('<div id="admin">Hi Mascha! <a id="logout" href="cms/posts/logout.php">(abmelden)</a></div>');
	$('.cms a.icon').click(function() {
		clickIcon(this);
	});
});

function clickIcon(icon) {
	var parent = $(icon).parent();
	var formdata = parent.find('.formdata');
	formdata.appendTo('body');
	formdata.css({ "display" : "block" });
	
	formdata.find('a.cancel').bind('click', function() {
		var formdata = $(this).parents('.formdata')
		formdata.appendTo(parent);
		formdata.css({ "display" : "none" });
	});
	
	if ($(icon).hasClass('view')) {
		if (!$(icon).hasClass('filled')) {
			fillgrid(formdata);
			$(icon).addClass('filled');
		}
	}
}

function getAttr(element, attribute) {
	var attr = $(element).attr(attribute);
	if (typeof attr !== typeof undefined && attr !== false) {
	    return attr;
	}
	return ""; 
}

function getColumns(formdata) {
	var columns = [];
	formdata.find('.field-option').each(function() {
		var fname = getAttr(this, "name");
		var cols = {id: fname, name: fname, field: fname, resizable: true};
				
		var editor = getAttr(this, "editor"); // "text" "integer", "date", "checkbox", "rtf"		
		if (editor != "") {
			var edit = Slick.Editors.Text;			
			switch (editor) {
				case "integer": 
					edit = Slick.Editors.Integer;
					break;
				case "date":
					edit = Slick.Editors.Date;
					break;
				case "checkbox":
					edit = Slick.Editors.Checkbox;
					break;
				case "rtf":
					edit = Slick.Editors.LongText;
					break;
			}
			cols["editor"] = edit;
		}					
		
		var pk = getAttr(this, "pk");
		if (pk == "1") {
			cols["pk"] = 1;
		}
		
		columns.push(cols);
	});
	
	return columns;
}

function getData(formdata, columns) {
	var data = [];
	var hdata = formdata.find('.fieldvalues').html();
	var datalines = hdata.split('{;;;}');
	for (var i = 0; i < datalines.length; i++) {	
		if (datalines[i].trim() != "") {	
			var dataValues = datalines[i].split('{;}');
			var dataRow = [];
			for (var j = 0; j < columns.length; j++) {			
				dataRow[columns[j]["id"]] = dataValues[j].trim();
			}
			data.push(dataRow);
		}
	}
	return data;
}


function fillgrid(formdata) {
	var columns = getColumns(formdata);
	var data = getData(formdata, columns);
	var options = {
	    editable: true,	    
	    enableCellNavigation: true,
	    asyncEditorLoading: false,
	    autoEdit: false,
	};
	
	var grid = new Slick.Grid(formdata.find('.slickgrid'), data, columns, options);
	grid.setSelectionModel(new Slick.CellSelectionModel());
	
	grid.onCellChange.subscribe(function (e, args) {				    	
      	var item = args.item;
      	
      	var postarr = { __tablename : formdata.find('input[name="__tablename"]').val() }
      	var columns = grid.getColumns();
      	for (var i = 0; i < columns.length; i++) {
      		if (columns[i]['pk'] == 1) {
	      		for (name in item) {
	      			if (columns[i]['id'] == name) {
	      				postarr['pk_' + name] = item[name];
	      			}
	      		}
      		}
      	}
      	
      	var count = 0;
      	for (name in item) {
      		if (count++ == args.cell) {
      			postarr[name] = item[name];
      			break;
      		}
      	}
      	
      	formdata.find('.loading').css({ "display" : "block" });
      	formdata.find('input[type="submit"]').val("speichert..");
      	$.ajax({
			url: "cms/posts/db/update.php",
			type: 'POST',
			data: postarr,
			success: function(res) {				
		    	formdata.find('.loading').css({ "display" : "none" });
		      	formdata.find('input[type="submit"]').val("Fertig");
		    }	
		});
		
    });
    
    formdata.find('form').submit(function() {
    	formdata.find('a.cancel').click();    	
    	event.preventDefault();	
    });
    
}  

