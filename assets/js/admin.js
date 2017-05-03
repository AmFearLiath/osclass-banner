$(document).ready(function(){
    
    function saveSort(data) {
        
        $("#sortStatus").html('Saving sort order').fadeToggle("slow");
        
        $.ajax({
            data: data,
            type: 'POST',
            url: '/oc-content/plugins/banner/admin/config.php'
        }).done(function(){
            $("#sortStatus").html('Sort order saved...').delay(1500).fadeToggle("slow");    
        }).fail(function(){
            $("#sortStatus").html('Can not save new sort order').delay(1500).fadeToggle("slow");    
        });
    }
    
    $(document).on("click", "#banners button.add", function(event){
        
        if ($("#banner_add").is(":visible")) {
            $("#banners .widget-title h3").fadeOut(function(){
                $("#banners .widget-title h3").html('Banner').fadeIn();
                $("#banners button.add").html("<i class=\"fa fa-plus\"></i>").removeClass("btn-danger").addClass("btn-info");   
            });                
        } else {
            $("#banners .widget-title h3").fadeOut(function(){
                $("#banners .widget-title h3").html('Add Banner').fadeIn();
                $("#banners button.add").html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");   
            });    
        }
        $("#banner_add").slideToggle("fast");
    });
    
    $(document).on("click", "#positions button.add", function(event){
        
        if ($("#position_add").is(":visible")) {
            $("#positions .widget-title h3").fadeOut(function(){
                $("#positions .widget-title h3").html('Positions').fadeIn();
                $("#positions button.add").html("<i class=\"fa fa-plus\"></i>").removeClass("btn-danger").addClass("btn-info");   
            });                
        } else {
            $("#positions .widget-title h3").fadeOut(function(){
                $("#positions .widget-title h3").html('Add Position').fadeIn();
                $("#positions button.add").html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");   
            });    
        }
        $("#position_add").slideToggle("fast");
    });
    
    $(document).on("click", ".positionTools button.show-code", function(event){
        event.preventDefault();
        $('#'+$(this).data("id")).slideToggle("fast");    
    })
    
    $(document).on("click", ".openTab", function(event){
        event.preventDefault();
        
        var id = $(this).data('id'),
            icon = $(this).children('i');
            
        $("#tab_"+id).slideToggle("slow");
        if ($(icon).hasClass('fa-chevron-down')) {
            $(icon).switchClass('fa-chevron-down', 'fa-chevron-up', 1000, 'swing');    
        } else {
            $(icon).switchClass('fa-chevron-up', 'fa-chevron-down', 1000, 'swing');    
        }    
    });
    
    $(document).on("click", ".edit-slide", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/banner/admin/config.php?editSlide='+id;
        
        $.get(url, function(data) {
            var source  = $('<div>'+data+'</div>'),
                content = source.find('#banner_add').html();
                
            $("#banner_add").html(content).fadeIn(function(){
                var pos = $("#banner_add").offset().top;
                
                $("#banners .widget-title h3").html('Edit Banner').fadeIn();
                $("#banners button.add").html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");
                
                $('html, body').stop().animate({
                    'scrollTop': $("#banner_add").offset().top-140
                }, 900, 'swing', function () {
                    window.location.hash = $("#banner_add");
                });   
            });
                
        });
    });
    
    $(document).on("click", ".edit-position", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/banner/admin/config.php?editPosition='+id;
        
        $.get(url, function(data) {
            var source  = $('<div>'+data+'</div>'),
                content = source.find('#position_add').html();
            
            console.log(content);
                
            $("#position_add").html(content).fadeIn(function(){
                var pos = $("#position_add").offset().top;
                
                $("#positions .widget-title h3").html('Edit Banner').fadeIn();
                $("#positions button.add").html("<i class=\"fa fa-minus\"></i>").removeClass("btn-info").addClass("btn-danger");
                
                $('html, body').stop().animate({
                    'scrollTop': $("#position_add").offset().top-140
                }, 900, 'swing', function () {
                    window.location.hash = $("#position_add");
                });   
            });
                
        });
    });
    
    $(document).on("click", ".delete-slide", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/banner/admin/config.php?deleteSlide='+id;
            
        if (confirm("You really want to delete this slide? This action cannot be undone!")) {
            $.get(url, function(data) {
                $("#slide-"+id).remove();
            });    
        }
    });
    
    $(document).on("click", ".delete-position", function(){
        var id = $(this).data("id"),
            url = '/oc-content/plugins/banner/admin/config.php?deletePosition='+id;
            
        if (confirm("You really want to delete this position? This action cannot be undone!")) {
            $.get(url, function(data) {
                $("#position-"+id).remove();
            });    
        }
    });
    
    $(document).on('click', 'form button[type=submit]', function(e) {
        var regex = new RegExp("^[a-zA-Z0-9_-]+$"),
            str = $("input[name=positionName]").val();
        
        if(!regex.test(str)) {
            e.preventDefault();
            alert("Your input for the position name is invalid.");
            return false;          
        }
    });
    
    $("li.tableContent").sortable({
        axis: 'y',
        connectWith: "li.tableContent",
        placeholder: "sort-highlight",
        revert: true,
        scroll: true,
        tolerance: "pointer",
        receive: function(event, ui) {
            var data    = $(this).sortable('serialize'),
                newPos    = $(this).data("position");
                
            saveSort('position='+newPos+'&'+data);
        },
        update: function (event, ui) {
            var data    = $(this).sortable('serialize'),
                newPos  = $(this).data("position"),
                oldPos  = ui.item.children('li.slidePosition').html(),
                slides  = $(this).children("ul");
            
            $(slides).each(function(i) {
                $(this).children("li.slidePriority").html(i+1);    
            });
            
            if (newPos === oldPos) {
                saveSort('position='+newPos+'&'+data);    
            }
        }
    }).disableSelection();
});