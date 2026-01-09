@extends('frontend.includes.layout')
@section('css')

@endsection
@section('content')
<main class="main">
    <!-- shop single -->
    <div class="shop-single py-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8 pt-4">
                    <div class="shop-single-info">
                        <h3>Full Body Checkup - Essential in Bangalore</h3>
                        <div class="shop-single-price ">
                            <del>$690</del>
                            <span class="amount">$650</span>
                            <span class="discount-percentage">30% Off</span>

                        </div>
                        <div class="product-rate mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <!-- <p>1K people booked this test</p> -->
                        <a href="#" class="theme-btn btn-sm p-1 px-3 mb-3 add" style="right:0;"><span class="far fa-shopping-bag"></span>Add To Cart</a>
                        <div class="shop-single-cs">
                        </div>
                        <div class="shop-single-sortinfo">
                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                <div class="col">
                                    <div class="card border-0">

                                        <div class="card-body report-card py-0">
                                            <h6 class="card-title">Reports Within:</h6>
                                            <p class="card-text">7 hours</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card border-0">

                                        <div class="card-body report-card py-0">
                                            <h5 class="card-title">Tests included </h5>
                                            <p class="card-text">91</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="report-card ps-3 mt-3">
                            <h6 class="text-muted ">Requisites</h6>
                            <p>
                                   <span> Blood Sample</span>
                               
                                   <span>  No Fasting Required</span>
                                
                                   <span> Urine Sample</span>
                            </p>
                            </div> 
                        </div>
                        <div class="shop-single-action">
                            <div class="row align-items-center">
                                <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="shop-single-btn">

                                        <!-- <a href="#" class="theme-btn theme-btn2" data-tooltip="tooltip" title="Add To Wishlist"><span class="far fa-heart"></span></a>
                                        <a href="#" class="theme-btn theme-btn2" data-tooltip="tooltip" title="Add To Compare"><span class="far fa-arrows-repeat"></span></a> -->
                                    </div>
                                </div>
                                <!-- <div class="col-md-6 col-lg-12 col-xl-6">
                                    <div class="shop-single-share">
                                        <span>Share:</span>
                                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#"><i class="fab fa-x-twitter"></i></a>
                                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 h-100 border border-1 p-4 pb-5">
                    <h4>Related Test</h4>
                        <div class="product-list-item shadow-sm border"
                            style="overflow: hidden;background: white;">
                            <div class="product-list-content" style="  background: white;">
                                <span class="bg-primary text-light small px-2" style="
                                    border-radius: 0px 0px 5px 5px;
                                    position: absolute;
                                    left: 290px;
                                    margin-top: -10px;
                                ">Checkup</span>
                                <h6 style="
                                    background-color: white;
                                " class=" p-2 border-5 border-start border-primary mt-3"><a href="shop-single.html"
                                        class="text-primary">Full body checkups in Bangalore</a></h6>
                                <div class="product-list-price">
                                    <del>$60.00</del><span class="text-primary">$40.00</span>
                                    <span class="text-danger small">10% Off</span>
                                </div>

                                <div class="product-list-price">


                                    <span class="text-dark small"><i
                                            class="fa-solid fa-droplet text-danger"></i> Blood Sample</span>
                                    |
                                    <span class="text-dark small"><i
                                            class="fa-solid fa-utensils text-warning"></i> Fasting
                                        Required</span>
                                    <br>


                                </div>

                            </div>
                            <a href="#" class="product-list-btn" data-bs-placement="left"
                                data-tooltip="tooltip" aria-label="Add To Cart"
                                data-bs-original-title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                        </div>
                        <div class="product-list-item shadow-sm border"
                            style="overflow: hidden;background: white;">
                            <div class="product-list-content" style="  background: white;">
                                <span class="bg-primary text-light small px-2" style="
                                    border-radius: 0px 0px 5px 5px;
                                    position: absolute;
                                    left: 290px;
                                    margin-top: -10px;
                                ">Checkup</span>
                                <h6 style="
                                    background-color: white;
                                " class=" p-2 border-5 border-start border-primary mt-3"><a href="shop-single.html"
                                        class="text-primary">Full body checkups in Bangalore</a></h6>
                                <div class="product-list-price">
                                    <del>$60.00</del><span class="text-primary">$40.00</span>
                                    <span class="text-danger small">10% Off</span>
                                </div>

                                <div class="product-list-price">


                                    <span class="text-dark small"><i
                                            class="fa-solid fa-droplet text-danger"></i> Blood Sample</span>
                                    |
                                    <span class="text-dark small"><i
                                            class="fa-solid fa-utensils text-warning"></i> Fasting
                                        Required</span>
                                    <br>


                                </div>

                            </div>
                            <a href="#" class="product-list-btn" data-bs-placement="left"
                                data-tooltip="tooltip" aria-label="Add To Cart"
                                data-bs-original-title="Add To Cart"><i class="far fa-shopping-bag"></i></a>
                        </div>
                </div>
            </div>

            <!-- shop single details -->
            <div class="shop-single-details">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-tab1" data-bs-toggle="tab" data-bs-target="#tab1"
                            type="button" role="tab" aria-controls="tab1" aria-selected="true">About The Test</button>
                        <button class="nav-link" id="nav-tab2" data-bs-toggle="tab" data-bs-target="#tab2"
                            type="button" role="tab" aria-controls="tab2" aria-selected="false"> List of Parameters</button>
                        <button class="nav-link" id="nav-tab3" data-bs-toggle="tab" data-bs-target="#tab3"
                            type="button" role="tab" aria-controls="tab3" aria-selected="false">Test Preparation</button>
                        <button class="nav-link" id="nav-tab4" data-bs-toggle="tab" data-bs-target="#tab4"
                            type="button" role="tab" aria-controls="tab4" aria-selected="false">Why This Test</button>
                        <button class="nav-link" id="nav-tab5" data-bs-toggle="tab" data-bs-target="#tab5"
                            type="button" role="tab" aria-controls="tab5" aria-selected="false">FAQ</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="nav-tab1">
                        <div class="shop-single-desc">
                            <h3>What is a Full Body Checkup - Essential ?</h3>
                            <p class="mt-3">
                                Screening tests play a crucial role in preventive health care. They not only diagnose conditions after symptoms arise but also play a vital role in early detection when treatment may be more effective. Orange Health Labs’ Full Body Checkup - Essential package includes a range of screening tests carefully selected by doctors. These tests are essential for assessing liver and kidney function, blood sugar levels, thyroid health, cholesterol, and overall blood and urine health. It also includes tests to screen for vitamin deficiencies, including those for vitamin D and B12. Through this package, we aim to assist doctors in identifying potential health disorders, which is crucial for early treatment and maintaining overall health.
                            </p>
                            <!-- <div class="row">
                            <div class="col-lg-5 col-xl-4">
                                <div class="shop-single-list">
                                    <h5 class="title">Features</h5>
                                    <ul>
                                        <li>Modern Art Deco Chaise Lounge</li>
                                        <li>Unique cylindrical design copper finish</li>
                                        <li>Covered in grey velvet fabric</li>
                                        <li>Modern Bookcase in Copper Colored Finish</li>
                                        <li>Use of Modern Materials</li>
                                        <li>Mirrored compartments and upgraded interior</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-5">
                                <div class="shop-single-list">
                                    <h5 class="title">Specifications</h5>
                                    <ul>
                                        <li><span>Dimensions:</span> 4ft W x 7ft h</li>
                                        <li><span>Model Year:</span> 2024</li>
                                        <li><span>Available Sizes:</span> 8.5, 9.0, 9.5, 10.0</li>
                                        <li><span>Manufacturer:</span> Reebok Inc.</li>
                                        <li><span>Available Colors:</span> White/Red/Blue,Black/Orange/Green</li>
                                        <li><span>Made In:</span> USA</li>
                                    </ul>
                                </div>
                            </div>
                        </div> -->
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="nav-tab2">
                        <div class="shop-single-additional">
                            <h3>Full Body Checkup - Essential Parameters</h3>
                            
                            <div class="row p-3 px-md-5 pb-5">
                                <div class="col-lg-10 col-md-12">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingOne">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white bg-white shadow-none"
                                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                    Glycosylated Haemoglobin (HbA1c)
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        The Glycosylated Haemoglobin (HbA1c) test measures the average blood sugar level over the past two to three months. It helps in diagnosing and monitoring diabetes by checking how well blood sugar levels are being managed over a longer period.
                                                    </p>
                                                    <ul>
                                                        <li>Glycosylated Haemoglobin (HbA1c)</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingTwo">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                                    aria-controls="flush-collapseTwo">
                                                    Lipid Profile
                                                </button>
                                            </h2>
                                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        A lipid profile is a group of blood tests that measures the levels of different types of lipids (fats) present in the body, including cholesterol and triglycerides. This profile is typically used to assess an individual's risk of developing heart disease.
                                                    </p>
                                                    <ul class="lists ms-4 mt-3 ">
                                                        <li>HDL Cholesterol</li>
                                                        <li>Cholesterol</li>
                                                        <li>Triglycerides (TGL)</li>
                                                        <li>VLDL</li>
                                                        <li>Cholesterol:HDL</li>
                                                        <li>LDL:HDL</li>
                                                        <li>LDL Cholesterol (Calculated)</li>
                                                        <li>Non-HDL Cholesterol</li>
                                                        <li>HDL/LDL ratio</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingThree">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                                    Liver Function Test (LFT)
                                                </button>
                                            </h2>
                                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>The Liver Function Test (LFT) is a group of tests used to evaluate the health of your liver. It measures the levels of proteins, liver enzymes, and bilirubin in your blood. An LFT can help diagnose liver diseases such as hepatitis, cirrhosis, or liver cancer.</p>
                                                    <ul class="lists ms-4 mt-3 ">
                                                        <li>Alkaline Phosphatase</li>

                                                        <li>SGOT / AST - Aspartate AminoTransferase</li>

                                                        <li>Alanine AminoTransferase/ ALT (SGPT)</li>

                                                        <li>Gamma-Glutamyl Transferase (GGT)</li>

                                                        <li>Total Bilirubin</li>

                                                        <li>Direct Bilirubin</li>

                                                        <li>Indirect Bilirubin</li>

                                                        <li>Total protein</li>

                                                        <li>ALBUMIN</li>

                                                        <li>Globulin</li>

                                                        <li>A:G ratio</li>

                                                        <li>SGOT/SGPT ratio</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingFour">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false"
                                                    aria-controls="flush-collapseFour">
                                                    Blood Sugar
                                                </button>
                                            </h2>
                                            <div id="flush-collapseFour" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">This test measures the amount of glucose, or sugar, in the blood. It's typically used to screen for, diagnose, or monitor diabetes. It can be done in a fasting state, randomly or post-meal (postprandial).
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingFive">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false"
                                                    aria-controls="flush-collapseFive">
                                                    Thyroid Function Test (TFT)
                                                </button>
                                            </h2>
                                            <div id="flush-collapseFive" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>The Thyroid Function Test (TFT) comprises a set of blood assessments designed to evaluate the thyroid gland's performance. These tests measure thyroid-stimulating hormone (TSH), total T4, and total T3 levels, aiding in the detection of hyperthyroidism (overactivity) or hypothyroidism (underactivity) in the thyroid.</p>
                                                    <ul class="lists ms-4 mt-3 ">
                                                        <li>Total T3</li>
                                                        <li>Total T4</li>
                                                        <li>TSH</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingSix">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false"
                                                    aria-controls="flush-collapseSix">
                                                    Urine Complete Analysis
                                                </button>
                                            </h2>
                                            <div id="flush-collapseSix" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        A Urine Complete Analysis, also known as Urinalysis, is a test that evaluates a sample of a person's urine. It can detect and measure a range of substances, including cells, cell fragments, and substances such as crystals or casts in the urine. This test is used to detect urinary tract infections, kidney diseases, and diabetes, among other health conditions.
                                                    </p>
                                                    <ul class="lists ms-4 mt-3">
                                                        <li>Colour</li>

                                                        <li>Appearance</li>
                                                        <li>Volume</li>
                                                        <li>pH</li>
                                                        <li>Specific gravity</li>
                                                        <li>Protein</li>
                                                        <li>Glucose</li>
                                                        <li>Ketone bodies</li>
                                                        <li>Bilirubin</li>
                                                        <li>Blood</li>
                                                        <li>Urobilinogen</li>
                                                        <li>Leucocyte esterase</li>
                                                        <li>Nitrite</li>
                                                        <li>Pus cells</li>
                                                        <li>Epithelial cells</li>
                                                        <li>RBCs</li>
                                                        <li>Granular casts</li>
                                                        <li>Hyaline casts</li>
                                                        <li>Calcium oxalate crystals</li>
                                                        <li>Uric acid crystals</li>
                                                        <li>Phosphate crystals</li>
                                                        <li>Amorphous urates</li>
                                                        <li>Amorphous phosphates</li>
                                                        <li>Yeasts</li>
                                                        <li>Bacteria</li>
                                                        <li>Parasites</li>
                                                        <li>Mucus</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingseven">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseseven"
                                                    aria-expanded="false" aria-controls="flush-collapseseven">
                                                    Vitamin B12
                                                </button>
                                            </h2>
                                            <div id="flush-collapseseven" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingseven" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>This test measures the levels of Vitamin B12 in your blood. Vitamin B12 is essential for maintaining healthy nerve cells and creating DNA and red blood cells. A deficiency can lead to fatigue, weakness, and other health problems. This test can help diagnose a Vitamin B12 deficiency and guide treatment.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingseven">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapEight"
                                                    aria-expanded="false" aria-controls="flush-collapEight">
                                                    Vitamin D, Total
                                                </button>
                                            </h2>
                                            <div id="flush-collapEight" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingseven" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>The Vitamin D, 25-Hydroxy test measures the amount of Vitamin D in the body. Vitamin D is crucial for bone health as it helps the body to absorb calcium. Low levels of Vitamin D can lead to bone diseases like rickets in children and osteoporosis in adults. This test helps in diagnosing Vitamin D deficiency or toxicity.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingseven">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapNine"
                                                    aria-expanded="false" aria-controls="flush-collapNine">
                                                    Kidney Function Test with Electrolytes (KFT / RFT)
                                                </button>
                                            </h2>
                                            <div id="flush-collapNine" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingseven" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        The Kidney Function Test with Electrolytes, also known as Renal Function Test (RFT), is a group of tests that evaluate how well the kidneys are working. This includes measurements of electrolyte levels (like sodium, potassium, and chloride), BUN (blood urea nitrogen), creatinine, and GFR (glomerular filtration rate), which can help assess kidney health and diagnose kidney-related conditions.
                                                    </p>
                                                    <ul class="lists mt-3 ms-4 ">
                                                        <li>Urea</li>
                                                        <li>Blood Urea Nitrogen (BUN)</li>
                                                        <li>Uric acid</li>
                                                        <li>Phosphorus</li>
                                                        <li>Calcium</li>
                                                        <li>Creatinine</li>
                                                        <li>eGFR</li>
                                                        <li>Sodium</li>
                                                        <li>Potassium</li>
                                                        <li>Chloride</li>
                                                        <li>BUN Creatinine ratio</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item my-3 border-0 rounded-3 shadow-sm p-0 bg-white">
                                            <h2 class="accordion-header bg-white shadow-none border-0" id="flush-headingseven">
                                                <button class="accordion-button collapsed text-dark fw-bold bg-white shadow-none" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapTen"
                                                    aria-expanded="false" aria-controls="flush-collapTen">
                                                    Complete Blood Count (CBC) with ESR
                                                </button>
                                            </h2>
                                            <div id="flush-collapTen" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingseven" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    <p>
                                                        This is a combination of the Complete Blood Count (CBC), which measures various components of the blood, along with the Erythrocyte Sedimentation Rate (ESR). The ESR is a type of blood test that measures how quickly erythrocytes (red blood cells) settle at the bottom of a test tube containing a blood sample. A faster than normal rate may indicate a systemic disease, such as inflammation, infection, or cancer.
                                                    </p>
                                                    <ul class="lists mt-3 ms-4 ">
                                                        <li>Red Blood Cell Count (RBC Count)</li>
                                                        <li>HEMATOCRIT</li>
                                                        <li>Haemoglobin (Hb)</li>
                                                        <li>Total WBC Count (TC)</li>
                                                        <li>MCV</li>
                                                        <li>MCH</li>
                                                        <li>MCHC</li>
                                                        <li>RDW</li>
                                                        <li>Absolute Neutrophil Count (ANC)</li>
                                                        <li>Absolute Lymphocyte Count (ALC)</li>
                                                        <li>Absolute Eosinophil Count (AEC)</li>
                                                        <li>Absolute monocyte count</li>
                                                        <li>absolute basophil count</li>
                                                        <li>platelets</li>
                                                        <li>neutrophil</li>
                                                        <li>Monocyte</li>
                                                        <li>Eosinophils</li>
                                                        <li>Basophils</li>
                                                        <li>mentzer index</li>
                                                        <li>Sehgal Index</li>
                                                        <li>platelet hematocrit</li>
                                                        <li>Erythrocyte Sedimentation Rate (ESR)</li>
                                                        <li>MPV</li>
                                                        <li>Neutrophil lymphocyte ratio</li>
                                                        <li>lymphocyte count</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>





                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="nav-tab3">
                        <div class="shop-single-review">
                            <h3>
                                Full Body Checkup - Essential Preparation
                            </h3>
                            <p class="mt-3">
                                A few points to be considered before doing a Full Body Checkup - Essential at home are as follows:
                            </p>
                            <h5 class="mt-3">Prerequisites</h5>
                            <p>There is no need to fast in order to prepare for this Health Checkup.</p>
                            <h5 class="mt-3">Best Time to Get Tested</h5>
                            <p>This Health Checkup can be conducted at any time during the day.</p>
                            <h5 class="mt-3">Who Should Avail This Checkup</h5>
                            <p>This checkup would be beneficial for:</p>
                            <ul class="lists mt-3 ms-4">
                                <li>People who have high risk factors—such as unhealthy lifestyle choices, a medical history, or a family history of certain conditions—that increase their risk of developing health issues.</li>
                                <li>People who want to take charge of their health by spotting any problems before symptoms appear.</li>
                                <li>People over 30, who should get these examinations once or twice a year.</li>
                            </ul>
                            <h5  class="mt-3">Cautions Before Taking This Checkup</h5>
                            <p>
                                This checkup includes several types of tests, so it's important to know that some medications or supplements may affect the results. You should notify your treating doctor about any drugs or supplements you are taking.

                            </p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="nav-tab4">
                        <div class="shop-single-review">
                            <h3>
                                Why Take the Full Body Checkup - Essential Checkup?
                            </h3>
                            <p class="mt-3">
                                Full Body Checkups are crucial for maintaining and improving overall health and allow for:
                            </p>
                            <ul class="lists mt-3 ms-4">
                                <li>Early diagnosis of health conditions</li>
                                <li>Timely risk assessment in individuals with medical or family history of certain health conditions</li>
                                <li>Disease monitoring for existing health conditions</li>
                                <li>Monitoring of treatment efficacy</li>
                                <li>
                                    Monitoring of treatment efficacy
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shop single details end -->


            <!-- related item -->
            <!-- <div class="product-area related-item pt-40">
            <div class="container px-0">
                <div class="row">
                    <div class="col-12">
                        <div class="site-heading-inline">
                            <h2 class="site-title">Related Items</h2>
                            <a href="#">View More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row g-4 item-2">
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type new">New</span>
                                <a href="shop-single.html"><img src="assets/img/product/07.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                <div class="product-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-bottom">
                                    <div class="product-price">
                                        <span>$100.00</span>
                                    </div>
                                    <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                        <i class="far fa-shopping-bag"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type hot">Hot</span>
                                <a href="shop-single.html"><img src="assets/img/product/08.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                <div class="product-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-bottom">
                                    <div class="product-price">
                                        <span>$100.00</span>
                                    </div>
                                    <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                        <i class="far fa-shopping-bag"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type oos">Out Of Stock</span>
                                <a href="shop-single.html"><img src="assets/img/product/12.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                <div class="product-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-bottom">
                                    <div class="product-price">
                                        <span>$100.00</span>
                                    </div>
                                    <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                        <i class="far fa-shopping-bag"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="product-item">
                            <div class="product-img">
                                <span class="type discount">10% Off</span>
                                <a href="shop-single.html"><img src="assets/img/product/14.png" alt=""></a>
                                <div class="product-action-wrap">
                                    <div class="product-action">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quickview" data-bs-placement="right" data-tooltip="tooltip" title="Quick View"><i class="far fa-eye"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Wishlist"><i class="far fa-heart"></i></a>
                                        <a href="#" data-bs-placement="right" data-tooltip="tooltip" title="Add To Compare"><i class="far fa-arrows-repeat"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3 class="product-title"><a href="shop-single.html">Surgical Face Mask</a></h3>
                                <div class="product-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <div class="product-bottom">
                                    <div class="product-price">
                                        <del>$120.00</del>
                                        <span>$100.00</span>
                                    </div>
                                    <button type="button" class="product-cart-btn" data-bs-placement="left" data-tooltip="tooltip" title="Add To Cart">
                                        <i class="far fa-shopping-bag"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
            <!-- related item end -->
        </div>
    </div>
    <!-- shop single end -->

</main>



<div class="modal quickview fade" id="quickview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="quickview" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                    class="far fa-xmark"></i></button>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-img">
                            <img src="assets/img/product/04.png" alt="#">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="quickview-content">
                            <h4 class="quickview-title">Surgical Face Mask</h4>
                            <div class="quickview-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <i class="far fa-star"></i>
                                <span class="rating-count"> (4 Customer Reviews)</span>
                            </div>
                            <div class="quickview-price">
                                <h5><del>$860</del><span>$740</span></h5>
                            </div>
                            <ul class="quickview-list">
                                <li>Brand:<span>Medica</span></li>
                                <li>Category:<span>Healthcare</span></li>
                                <li>Stock:<span class="stock">Available</span></li>
                                <li>Code:<span>789FGDF</span></li>
                            </ul>
                            <div class="quickview-cart">
                                <a href="#" class="theme-btn">Add to cart</a>
                            </div>
                            <div class="quickview-social">
                                <span>Share:</span>
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-x-twitter"></i></a>
                                <a href="#"><i class="fab fa-pinterest-p"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('js')

@endsection