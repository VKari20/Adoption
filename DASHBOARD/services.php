<?php include "nav/navbar.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrphanConnect</title>
    <link rel="stylesheet" href="style.css">
    <style>


/* FAQ Section Styling */
.faq-section {
    margin-top: 50px;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* FAQ Grid */
.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

/* FAQ Item */
.faq-item {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.faq-item h2 {
    color: #007bff;
    font-size: 1.5em;
    margin-bottom: 10px;
    border-left: 5px solid #f0a500;
    padding-left: 10px;
}

.faq-item ul, .faq-item ol {
    margin: 10px 0;
    padding-left: 20px;
    font-size: 1em;
    line-height: 1.6;
    color: #444;
}

.faq-item li {
    margin-bottom: 10px;
}

.faq-item li::marker, .faq-item ol li::marker {
    color: #f0a500;
}
/* FAQ Section Styling */
.faq-section {
    padding: 40px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.faq-title {
    text-align: center;
    font-size: 2em;
    color: #333;
    margin-bottom: 20px;
    border-bottom: 2px solid #f0a500;
    padding-bottom: 10px;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}

.faq-item {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.faq-question {
    font-size: 1.5em;
    color: #007bff;
    cursor: pointer;
    margin-bottom: 10px;
    transition: color 0.3s;
}

.faq-question:hover {
    color: #d18d00;
}

.faq-answer {
    display: none; /* Hidden by default */
    color: #555;
    font-size: 1em;
    line-height: 1.6;
    margin-top: 10px;
}

.faq-answer.active {
    display: block; /* Show when active */
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    .faq-grid {
        grid-template-columns: 1fr;
    }

    .faq-item h2 {
        font-size: 1.3em;
    }
}

    
    </style>
</head>
<body>
    

        <!-- Service Section -->
        <section class="service-section">
            <div class="intro-container">
                <h1 style="color:#f0a500">Our Services</h1>
                <p>We offer a range of services to support families through the adoption journey, from guidance on the process to emotional support.</p>
            </div>
            
            <!-- Service Grid -->
            <div class="service-grid">
                <!-- First-Time Adoption Guide -->
                <div class="service-item">
                    <img src="Image/photo6.png" alt="Adoption Guidance" class="service-image">
                    <h3 class="service-title">First-Time Adoption Guide</h3>
                    <p>A step-by-step guide for new adoptive parents, covering requirements, workshops, and legal assistance.</p>
                    <div class="service-details">
                        <p>We provide new parents with a detailed roadmap of the adoption process, assisting them with everything from initial requirements to post-adoption support.</p>
                    </div>
                </div>

                <!-- Post-Adoption Follow-Ups -->
                <div class="service-item">
                    <img src="Image/photo3.jpg" alt="Post-Adoption Follow-Ups" class="service-image">
                    <h3 class="service-title">Post-Adoption Follow-Ups</h3>
                    <p>Regular check-ins to ensure the well-being of both the child and family, including integration and bonding support.</p>
                    <div class="service-details">
                        <p>Our post-adoption follow-ups include regular phone check-ins, scheduled visits, and resources to help families with any challenges they may face during the integration period.</p>
                    </div>
                </div>

                <!-- Psychological and Emotional Support Services -->
                <div class="service-item">
                    <img src="Image/photo5.png" alt="Psychological Support" class="service-image">
                    <h3 class="service-title">Psychological and Emotional Support</h3>
                    <p>Access to counseling, therapy, and support groups for adoptive families to ensure emotional wellbeing.</p>
                    <div class="service-details">
                        <p>Our support services offer individual and family counseling sessions, as well as group therapy to help parents and children adjust to their new life together.</p>
                    </div>
                </div>

                <!-- Educational Resources -->
                <div class="service-item">
                    <img src="Image/photo4.png" alt="Educational Resources" class="service-image">
                    <h3 class="service-title">Educational Resources and Workshops</h3>
                    <p>Courses, webinars, and resources on adoption topics to empower families and support their journey.</p>
                    <div class="service-details">
                        <p>We offer various educational materials and workshops to educate families about the adoption process, legal aspects, and how to foster positive family dynamics.</p>
                    </div>
                </div>
            </div>
        </section>
<!-- FAQ Section -->
<section class="faq-section">
    <div class="intro-container">
        <h1 style="color: #f0a500">Frequently Asked Questions</h1>
        <p>Find answers to common questions about the adoption process, matching, and post-adoption support.</p>
    </div>

    <!-- FAQ Grid -->
    <div class="faq-grid">
        <!-- Who Can Adopt -->
        <div class="faq-item">
        <h3 class="faq-question">Who Can Adopt?</h3>
        <!--<li>Eligibility criteria: age, marital status, financial stability.</li>
                <li>Legal requirements: local laws and required documents.</li>
                <li>Specific preferences: single parents, same-sex couples, international adopters.</li>
            </ul>-->
            <div class="faq-answer">
                <ul>
                    <li><strong>Eligibility Criteria:</strong>
                        <ul>
                            <li>Adoptive parents must be 25–65 years old.</li>
                            <li>Married couples must adopt jointly unless legally separated.</li>
                            <li>Single individuals can adopt but only children of the opposite gender (unless related).</li>
                            <li>A 21-year age gap between adopter and child is mandatory.</li>
                        </ul>
                    </li>
                    <li><strong>Citizenship:</strong> Kenyan citizens and foreign residents (with conditions).</li>
                    <li><strong>Suitability:</strong> Includes financial stability, medical fitness, and clear criminal records.</li>
                </ul>
                <p>Additional details like the adoption process and legal procedures are provided upon request or during agency consultations.</p>
            </div>
        </div>


       <!-- Adoption Process -->
<div class="faq-item">
    <h3 class="faq-question">What is the Adoption Process?</h3>
    <div class="faq-answer">
        <ol>
            <li><strong>Initial Inquiry:</strong> How potential adopters can express interest.</li>
            <li><strong>Screening:</strong> Background checks, home studies, and interviews.</li>
            <li><strong>Approval:</strong> Documentation and legal requirements for clearance.</li>
            <li><strong>Matching:</strong> Connecting the right child with the right family.</li>
            <li><strong>Finalization:</strong> Legal procedures to complete the adoption.</li>
        </ol>
    </div>
</div>


        <!-- Matching Process -->
<div class="faq-item">
    <h3 class="faq-question">What is the Matching Process?</h3>
    <div class="faq-answer">
        <ul>
            <li>
                <strong>Criteria for Matching:</strong> The process evaluates factors such as the child’s age, health, and personal preferences, as well as the family dynamics, location, and language to ensure compatibility.
            </li>
            <li>
                <strong>Decision-Making Process:</strong> Matching is conducted by qualified caseworkers, often supported by specialized software or through collaborative decisions in committees. The child’s needs are prioritized to identify the most suitable family.
            </li>
            <li>
                <strong>Transparency and Involvement:</strong> Adoptive parents are actively involved and informed throughout the matching process. They receive updates on potential matches and participate in discussions to build a connection with the child.
            </li>
            <li>
                <strong>Legal and Social Considerations:</strong> The process respects Kenyan legal frameworks and cultural contexts, ensuring the placement aligns with the best interests of the child and family.
            </li>
            <li>
                <strong>Introduction and Bonding Period:</strong> After a match is identified, an introductory phase allows the child and adoptive family to interact, guided by social workers to ensure a smooth transition.
            </li>
        </ul>
    </div>
</div>


        <!-- Post-Adoption Follow-Ups -->
        <div class="faq-item">
            <h2>Post-Adoption Follow-Ups</h2>
            <ul>
                <li>Timeline: 3 months, 6 months, and annually for the first 2 years.</li>
                <li>Includes: physical and emotional well-being of the child; adjustment of the child and family.</li>
                <li>Support services: counseling and parenting workshops.</li>
                <li>Reporting: progress reports and home visits.</li>
            </ul>
        </div>

        <!-- Other Services -->
        <div class="faq-item">
            <h2>Other Services Offered</h2>
            <ul>
                <li>Foster care programs.</li>
                <li>Sponsorship opportunities.</li>
                <li>Counseling and mental health support for children and families.</li>
                <li>Education and skill development for children in care.</li>
                <li>Community engagement programs to raise awareness.</li>
            </ul>
        </div>
    </div>
</section>

       

    <!-- JavaScript -->
    <script>
        // Collapsible service details toggle
        document.querySelectorAll('.service-title').forEach(title => {
            title.addEventListener('click', function() {
                const serviceDetails = this.nextElementSibling.nextElementSibling; // Get the associated details
                serviceDetails.classList.toggle('active'); // Toggle the display of details
            });
        });

        document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', function () {
        const answer = this.nextElementSibling; // Target the answer
        answer.classList.toggle('active'); // Toggle visibility
    });
});


    </script>
    <?php include "nav/footer.php"; ?>
</body>
</html>
