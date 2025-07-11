import{M as i}from"./bootstrap.esm-CY1Kz5oP.js";window.bootstrap={Modal:i};$(function(){$("button.add-cart-button").click(function(n){n.preventDefault();var a=$(this).data("id"),c=1;$.ajax({url:"/cart/"+a,type:"POST",data:{_token:$('meta[name="csrf-token"]').attr("content"),quantity:c},success:function(t){$.ajax({url:"/cart/modal",method:"GET",success:function(o){$("#cartModalBody").html(o),new bootstrap.Modal(document.getElementById("cartModal"),{}).show(),$.ajax({url:"/cart/count",method:"GET",success:function(r){const e=r.count,d=$("#cart-count-badge");e>0?d.text(e).removeClass("d-none"):d.addClass("d-none")}})}})},error:function(t){alert(t.responseJSON.message)}})}),$("a#filter-button").click(function(){s()});function s(){const n=$("form.sidebar-filter").serialize();$.ajax({method:"GET",url:"/",data:n}).done(function(a){$("div#products-wrapper").empty(),$.each(a.data,function(c,t){const o=`<div class="col-6 col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 border-0">
                                    <div class="card-img-top">
                                        <img src="https://dummyimage.com/300x240/fc00fc/000000.jpg&text=dawid+to+zjeb" class="img-fluid" alt="photo">
                                    </div>
                                    <div class="card-body text-center">
                                        <h4 class="card-title">
`+t.name+`                                        </h4>
                                        <h5 class="card-price small">
                                            <i>PLN `+t.price+`</i>
                                        </h5>
                                    </div>
                                    <button class="btn btn-success btn-sm add-cart-button" data-id="{{ $product->id }}">
                                        <i class="fas fa-cart-plus"></i> Dodaj do koszyka
                                    </button>
                                </div>
                            </div>`;$("div#products-wrapper").append(o)})}).fail(function(a){alert("nie dziala")})}});
