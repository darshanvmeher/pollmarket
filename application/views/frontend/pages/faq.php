<?php $this->load->view('frontend/partials/header'); ?>

<div class="section-heading">
    <div class="section-kicker">FAQ</div>
    <h1 class="section-title">Answers to common ecommerce and wholesale questions</h1>
</div>

<div class="accordion" id="faqAccordion">
    <div class="accordion-item">
        <h2 class="accordion-header"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">Do you support bulk orders?</button></h2>
        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion"><div class="accordion-body">Yes, Poll Market Solutions is designed with bulk ordering and repeat wholesale purchasing in mind.</div></div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">What products are highlighted?</button></h2>
        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Plastic garbage bags, stationery, silver foil papers, RFID seals, and paper bags.</div></div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Can I track orders?</button></h2>
        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion"><div class="accordion-body">Yes, the storefront includes a dedicated order tracking page.</div></div>
    </div>
</div>

<?php $this->load->view('frontend/partials/footer'); ?>
