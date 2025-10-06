import{M as u}from"./bootstrap.esm-CY1Kz5oP.js";window.bootstrap={Modal:u};$(document).on("click","button.add-cart-button",function(i){i.preventDefault();var e=$(this).data("id"),o=$(this).data("quantity-input"),a=1;if(o){var t=$(o);t.length&&(a=parseInt(t.val()))}$.ajax({url:"/cart/"+e,type:"POST",data:{_token:$('meta[name="csrf-token"]').attr("content"),quantity:a},success:function(s){$.ajax({url:"/cart/modal",method:"GET",success:function(d){console.log("Modal content:",d),$("#cartModalBody").html(d),new bootstrap.Modal(document.getElementById("cartModal"),{}).show(),$.ajax({url:"/cart/count",method:"GET",success:function(l){const n=l.count,r=$("#cart-count-badge");n>0?r.text(n).removeClass("d-none"):r.addClass("d-none")}})}})},error:function(s){alert(s.responseJSON.message)}})});$("a#filter-button").click(function(){m()});function m(){const i=$("form.sidebar-filter").serialize();$.ajax({method:"GET",url:"/",data:i}).done(function(e){$("div#products-wrapper").empty(),$.each(e.data,function(o,a){let t=a.images&&a.images.length>0?"/storage/products/"+a.images[0].image_url:"/storage/no-image.png";const d=`
                        <div class="col-12 col-sm-6 col-md-4">
                            <div id="pole" class="card h-100 border-0">
                                <a href="${"/product_page/"+a.id}" style="text-decoration: none">
                                    <div class="card-img-top text-center">
                                        <img src="${t}" class="img-fluid"
                                            alt="Photo"
                                            style="height: auto; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title">${a.name}</h4>
                                        <h5 class="card-price small"><i>${a.price} PLN </i></h5>
                                    </div>
                                </a>
                                <div style="display: none" id="product-quantity-{{$product->id}}">${a.quantity}</div>
                                <button class="btn btn-success btn-sm add-cart-button" data-id="${a.id}">
                                    <i class="fas fa-cart-plus"></i> Add to cart
                                </button>
                            </div>
                        </div>`;$("div#products-wrapper").append(d)})}).fail(function(e){alert("nie dziala")})}$(document).on("click",".category-button",function(i){i.preventDefault();let e=$(this).data("category");$.ajax({url:"/",method:"GET",data:{"filter[categories][]":e},dataType:"json"}).done(function(o){$("div#products-wrapper").empty(),$.each(o.data,function(a,t){let s=t.images&&t.images.length>0?"/storage/products/"+t.images[0].image_url:"/storage/no-image.png";const c=`
                    <div class="col-12 col-sm-6 col-md-4">
                        <div id="pole" class="card h-100 border-0">
                            <a href="${"/product_page/"+t.id}" style="text-decoration: none">
                                <div class="card-img-top text-center">
                                    <img src="${s}" class="img-fluid"
                                        alt="Photo"
                                        style="height: auto; object-fit: cover; width: 100%;">
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="card-title">${t.name}</h4>
                                    <h5 class="card-price small"><i>${t.price} PLN </i></h5>
                                </div>
                            </a>
                            <div style="display: none" id="product-quantity-{{$product->id}}">${t.quantity}</div>
                            <button class="btn btn-success btn-sm add-cart-button" data-id="${t.id}">
                                <i class="fas fa-cart-plus"></i> Add to cart
                            </button>
                        </div>
                    </div>`;$("div#products-wrapper").append(c)})}).fail(function(){alert("Błąd filtrowania produktów")})});$(document).on("click",".sort-link",function(i){i.preventDefault();let e=$(this).data("sort");$.ajax({url:"/",method:"GET",data:{sort:e},dataType:"json"}).done(function(o){$("div#products-wrapper").empty(),$.each(o.data,function(a,t){let s=t.images&&t.images.length>0?"/storage/products/"+t.images[0].image_url:"/storage/no-image.png";const c=`
                    <div class="col-12 col-sm-6 col-md-4">
                        <div id="pole" class="card h-100 border-0">
                            <a href="${"/product_page/"+t.id}" style="text-decoration: none">
                                <div class="card-img-top text-center">
                                    <img src="${s}" class="img-fluid"
                                        alt="Photo"
                                        style="height: auto; object-fit: cover; width: 100%;">
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="card-title">${t.name}</h4>
                                    <h5 class="card-price small"><i>${t.price} PLN </i></h5>
                                </div>
                            </a>
                            <div style="display: none" id="product-quantity-{{$product->id}}">${t.quantity}</div>
                            <button class="btn btn-success btn-sm add-cart-button" data-id="${t.id}">
                                <i class="fas fa-cart-plus"></i> Add to cart
                            </button>
                        </div>
                    </div>`;$("div#products-wrapper").append(c)})}).fail(function(){alert("Błąd filtrowania produktów")})});
