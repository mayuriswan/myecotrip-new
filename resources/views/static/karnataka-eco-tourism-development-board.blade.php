@extends('layouts.app')

@section('title', '')

@section('sidebar')

@endsection

@section('content')

    <!-- Header -->
    @include('layouts.header')

    <div class="container">
            <h1 class="page-title">About KEDB</h1>
        </div>

    <div class="container">
            <article class="post">
                <header class="post-header">
                    <div class="fotorama" data-allowfullscreen="true">
                        <img src="https://myecotrip.com/assets/img/slider/new-slider5.jpg" alt="Image Alternative text" title="196_365" />
                        <img src="https://karnatakaecotourism.com/wp-content/uploads/2017/09/12.jpg" alt="Image Alternative text" title="196_365" />
                        <img src="img/196_365_1200x500.jpg" alt="Image Alternative text" title="196_365" />
                    </div>
                </header>
                <div class="post-inner">
                    <h4 class="post-title text-darken">Karnataka Eco Tourism Development Board</h4>
                    <ul class="post-meta">
                        <li><i class="fa fa-calendar"></i><a href="#">15th August, 2013</a>
                        </li>
                        <!-- <li><i class="fa fa-user"></i><a href="#">Leah Kerr</a>
                        </li>
                        <li><i class="fa fa-tags"></i><a href="#">Travel</a>, <a href="#">Design</a>
                        </li>
                        <li><i class="fa fa-comments"></i><a href="#">16 Comments</a>
                        </li> -->
                    </ul>

                    <p class="text-bigger">On 15th August, 2013 the Karnataka state cabinet approved the proposal to set up the Karnataka eco tourism development board. The forest minister of Karnataka would serve as the chairman. The initiative would help the government immensely in protecting the wildlife, creating awareness about it, encouraging eco-tourism, forest safaris and also prevent damage to eco-system in the name of tourism.</p>

					<p class="text-bigger">The total contribution of Travel &amp; Tourism to the Indian GDP was INR 6,385.1 bn (6.6% of GDP) in 2012 and is forecast to rise by 7.3% in 2013, and to rise by 7.9% pa to INR 14,722.3 bn in 2023.</p>

					<p class="text-bigger">Considering that multitude of tourists visiting India and the domestic tourists do visit destinations that fall in the categories of Eco tourism and nature based tourism; it is pertinent that studies in the sector will add value and bring about positive growth and development if approached from a 360° angle. Karnataka has been a forefront of many aspects of tourism promotion and off late there has been a qualitative churn and an intensive focus on Eco tourism. The creation of the Karnataka Eco Tourism Development Board (KEDB) in 2013 has provided a fillip to bring in a new structure, a policy, create guidelines and frameworks, awareness and education, and provide opportunities for training and capacity building amongst the stakeholders, besides standards and certification.</p>
					<p class="text-bigger">&nbsp;</p>
					<p class="text-bigger">The objectives of the Karnataka Eco tourism board would primarily be;</p>
					<p class="text-bigger">1. To create awareness regarding the conservation of forests and wildlife amongst the people in general and children and youth, in particular.</p>
					<p class="text-bigger">2. To encourage and promote tourism activities in the country in general and the State of Karnataka, in particular.</p>
					<p class="text-bigger">3. To encourage local community involvement in ecotourism and provide greater employment opportunities and economic benefits to the local people.</p>
					<p class="text-bigger">4. To assist in formulation of policies, laws and guidelines for organized development of ecotourism activities in the state.</p>
					<p class="text-bigger">5. To conduct research and impact-studies in ecotourism areas.</p>
					<p class="text-bigger">6. To promote ecotourism as a front line non consumptive activity of Forest Department.</p>
					<p class="text-bigger">7. To develop good practices to be followed by ecotourism operators.</p>
					<p class="text-bigger">8. To standardize and operate certification of ecotourism operators.</p>
					<p class="text-bigger">9. To train and certify nature guides.</p>
					<p class="text-bigger">10. To produce literature and electronic media material required for nature education and ecotourism promotion.</p>
					<p class="text-bigger">11. To facilitate linkages between public and private operators n the cause of conservation of wildlife.</p>
					<p class="text-bigger">12. To coordinate and liaise with national /international bodies, experts and funding agencies and receive contribution and funds from Government of India, State Government, National and International funding agencies etc.</p>
					<p class="text-bigger">13. To encourage local community involvement in ecotourism.</p>
					<p class="text-bigger">14. To maintain and facilitate ecotourism activities inside the parks and forest areas.</p>
					<p class="text-bigger">15. To develop trekking trails and operate wildlife safaris in the “Protected Areas”.</p>
					<p class="text-bigger">16. To encourage public-private partnerships (PPP) in the area of ecotourism, wherever the law permits.</p>
				</div>
            </article>

            <h2>Organization Chart</h2>

            <div class="container">
                <table>
                    <tr>
                        <td></td>
                        <td>
                        <div class="row">
                            <div class ="col-md-1 col-centered">
                                <div class="card">
                                <img class="card-img imgcss"src="assets/img/orgimages/limbavali.jpeg" alt="FEE">
                                <div class="card-body">
                                    <h3 class="card-title">Governing Body</h3>
                                    <h4 class="card-text">Headed by Shri. Aravind Limbavali Hon'ble Forest Minister of Karnataka</h4>
                                </div>
                                </div>
                            </div>
                        </div>
                        </td>
                    </tr>
                </table>

                <div class="row">
                    <div class ="col-md-1 col-centered">
                        <div class="card">
                        <img class="card-img imgcss"src="assets/img/orgimages/madan.jpeg" alt="FEE">
                          <div class="card-body">
                            <h3 class="card-title">Chairman</h3>
                            <h4 class="card-text">Headed by Shri. Madan Gopal IAS (Retd.,) <br>Chairman of KEDB</br> </h4>
                          </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class ="col-md-1 col-centered">
                        <div class="card">
                        <img class="card-img imgcss" src="assets/img/orgimages/Salimat.jpeg" alt="FEE">
                          <div class="card-body">
                            <h3 class="card-title">Chief Executive Officer</h3>
                            <h4 class="card-text">Shri. Vijaykumar Salimath IFS</h4>
                          </div>
                        </div>
                    </div>
                </div>
            </div>



</div><!-- row -->

            <!-- <img src="{{ asset('assets/img/kedb/flowchart.png') }}" alt="Organization Chart"> -->


<style media="screen">
.row-centered {
text-align:center;
}
.col-centered {
display:inline-block;
float:none;
/* reset the text-align */
text-align:left;
/* inline-block space fix */
margin-right:-4px;
}
.card-body {
-ms-flex: 1 1 auto;
flex: 1 1 auto;
padding: 1.25rem;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 1.25rem;
    width: 46rem;
    border-color: #ed8323;
    margin: 7px;
    text-align: center;
}
.imgcss {
    width: 50%;
    margin-left: auto;
    margin-right: auto;
    margin-top: inherit;
}

.card-img {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 1.25rem;
    text-align: center;
}
</style>
            <br>
            <br>

            <div class="container">
                <!-- END COMMENTS -->
                <h3>Leave a Comment</h3>
                <form>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Website</label>
                                <input class="form-control" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Leave a Comment" />
                </form>
            </div>


            <div class="gap"></div>
        </div>
@endsection
