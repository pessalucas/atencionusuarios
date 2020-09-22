
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
                'action': 'ajaxloadnews', 
                'category': $('form#loadnews #category').val(), 
                'page': $page,
                'postperpage': $postperpage /*
                'security': $('form#loadnews #security').val() */},
            success: function(data){
                $('form#loadnews p.status').text(data.message);
                $page++;
                console.log( 'success');
                //Llega como data.news
                count=0;
                data.news.forEach(function() {
                    $( '#category-news' ).append(function() {
                       // console.log(data);
                        console.log(data.news);
                        var article=`
                        <div class="col-lg-6 isotope-item text-left" >
                                <article class="card custom-post-style-1 border-0"> 
                                    <header class="overlay overlay-show"> 
                                        <img class="img-fluid" src="`+  data.news[count].img +`" alt="Blog Post Thumbnail 1">
                                        <h4 class="font-weight-bold text-6 position-absolute bottom-0 left-0 z-index-2 ml-4 mb-4 pb-2 pl-2 pr-5 mr-5">
                                            <a href="`+  data.news[count].permalink +`" class="text-color-light text-decoration-none">`+  data.news[count].title +`</a>
                                        </h4>
                                    </header>
                                    <div class="card-body">
                                        <ul class="list list-unstyled custom-font-secondary pb-1 mb-2">
                                                <li class="list-inline-item line-height-1 mr-1 mb-0">`+  data.news[count].date +`</li>
                                                <li class="list-inline-item line-height-1 mb-0"><strong>`+  data.news[count].author +`</strong></li>
                                        </ul>
                                        <p class="custom-text-size-1 mb-2">`+  data.news[count].excerpt +`</p>
                                        <a href="`+  data.news[count].permalink +`" class="text-color-primary font-weight-bold text-decoration-underline custom-text-size-1">`+  data.news[count].title +`</a>
                                    </div>
                                </article>
                            </div> `;
                         
                        return article;
    
                    });
                    count++;
                  });

                  //Para mas de un post comparo si lenght es menor a 6
                  if(data.news.length === 0){
                    $('form#loadnews').hide();
                  }

               
/*
                    var emphasis = "<em>" + $( "p" ).length + " paragraphs!</em>";
                    return "<p>All new content for " + emphasis + "</p>";*/
                  
            },
            fail: function(data){
                $('form#loadnews p.status').text(data.message);
                console.log( 'fail');
            }
        }).fail( function(data){
            $('form#loadnews p.status').text(data.message);
        });
       
    });

});