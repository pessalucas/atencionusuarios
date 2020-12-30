
jQuery(document).ready(function($) {

    //Defino para la proxima pagina a pedir. Osea la 2. (6 se muestran automaticamente)
    var $page = 2;
    $postperpage = 6;

    $('form#loadnews').on('submit', function(e){
        e.preventDefault();
        $('form#loadnews p.status').show().text(ajax_loadnews_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_loadnews_object.ajaxurl,
            data: { 
                'action'     :  'ajaxloadnews', 
                'category'   :  $('form#loadnews #category').val(), 
                'page'       :  $page,
                'postperpage':  $postperpage,
                'nonce'      :  ajax_loadnews_object.nonce
            },
            success: function( json ){
                //Cuento el numero de pagina que estoy
                $page++;
                

                //Contador asignador de variables
                count=0;
                json.data.news.forEach(function() {  //Llega como //console.log ( json.data.news );
                    $( '#category-news' ).append(function() {
                        var article=`
                            <div class="col-lg-6 isotope-item text-left" >
                                    <article class="card custom-post-style-1 border-0"> 
                                        <header class="overlay overlay-show"> 
                                            <img class="img-fluid" src="`+  json.data.news[count].img +`" alt="Blog Post Thumbnail 1">
                                            <h4 class="font-weight-bold text-6 position-absolute bottom-0 left-0 z-index-2 ml-4 mb-4 pb-2 pl-2 pr-5 mr-5">
                                                <a href="`+  json.data.news[count].permalink +`" class="text-color-light text-decoration-none">`+  json.data.news[count].title +`</a>
                                            </h4>
                                        </header>
                                        <div class="card-body">
                                            <ul class="list list-unstyled custom-font-secondary pb-1 mb-2">
                                                    <li class="list-inline-item line-height-1 mr-1 mb-0">`+  json.data.news[count].date +`</li>
                                                    <li class="list-inline-item line-height-1 mb-0"><strong>`+  json.data.news[count].author +`</strong></li>
                                            </ul>
                                            <p class="custom-text-size-1 mb-2">`+  json.data.news[count].excerpt +`</p>
                                            <a href="`+  json.data.news[count].permalink +`" class="text-color-primary font-weight-bold text-decoration-underline custom-text-size-1">`+  json.data.news[count].title +`</a>
                                        </div>
                                    </article>
                                </div> `;
                        return article;
                    });
                    count++;
                  });

                  //Para mas de un post comparo si lenght es menor a 6 y oculto el boton
                  if( json.data.news.length < 6 ){
                    $('form#loadnews').hide();
                  }
            },
            fail: function( json ){
                console.log( json.data.message );
                $('form#loadnews').hide();
            }
        }).fail( function( json ){
            console.log( json.data.message  );
            $('form#loadnews').hide();
        });
       
    });

});