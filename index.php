<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodotti, Serivizi e Assistenza Informatica | Softwarengineering</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Header */
        .header {
            background-color: #fff;
            padding: 10px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-menu a:hover {
            color: #007bff;
        }

        .user-icon {
            width: 40px;
            height: 40px;
            background-color: #007bff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .user-icon:hover {
            background-color: #0056b3;
        }

        .user-icon svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 18px;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Services Grid */
        .services-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
        }

        .service-card {
            display: flex;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            min-height: 400px;
        }

        .service-content {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .service-image {
            flex: 1;
            background-size: cover;
            background-position: center;
            min-width: 300px;
        }

        .service-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .service-subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
            font-style: italic;
        }

        .service-description {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
            flex-grow: 1;
        }

        .service-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s;
            align-self: flex-start;
        }

        .service-btn:hover {
            background-color: #0056b3;
        }

        /* ERP Card - Blue gradient */
        .erp-card .service-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .erp-card .service-title,
        .erp-card .service-subtitle,
        .erp-card .service-description {
            color: white;
        }

        /* Web Solutions Card */
        .web-card {
            flex-direction: row-reverse;
        }

        .web-image {
            background-image: url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
        }

        /* Consulting Card */
        .consulting-image {
            background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
        }

        /* Training Card */
        .training-card {
            flex-direction: row-reverse;
        }

        .training-image {
            background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
        }

        /* Quote Sections */
        .quote-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            text-align: center;
            font-style: italic;
            font-size: 20px;
            color: #666;
        }

        .quote-section.blue {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .quote-section.green {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            color: white;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 40px 0;
            text-align: center;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .services-grid {
                grid-template-columns: 1fr;
            }

            .service-card,
            .web-card,
            .training-card {
                flex-direction: column;
            }

            .service-image {
                min-width: auto;
                height: 200px;
            }

            .nav-menu {
                display: none;
            }

            .hero-section h1 {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">Softwarengineering</div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#prodotti">Prodotti</a></li>
                    <li><a href="#servizi">Servizi</a></li>
                    <li><a href="#contatti">Contatti</a></li>
                </ul>
            </nav>
            <div style="display: flex; gap: 15px; align-items: center;">

                <div class="user-icon" onclick="goToUserPage()">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <section class="hero-section" id="home">
            <div>
                <h1>Soluzioni Softwarengineering</h1>
                <p>Un campo emergente nell'uso del Web finalizzato a soluzioni aziendali, Ã¨ rappresentato dai software
                    gestionali (ERP) fruibili direttamente da Internet. Si tratta di software gestionali su misura fatti
                    girare in appositi server remoti. Queste soluzioni permettono di risolvere problematiche aziendali
                    in modo particolarmente dinamico e flessibile, ma soprattutto, grazie alle moderne tecnologie
                    impiegate, risultano essere un modo estremamente sicuro di manipolare le informazioni.</p>
            </div>
        </section>

        <section class="services-container" id="prodotti">
            <div class="services-grid">
                <!-- ERP Card -->
                <div class="service-card erp-card">
                    <div class="service-content">
                        <div>
                            <h2 class="service-title">CLOUD ERP</h2>
                            <p class="service-subtitle">Softwarengineering</p>
                            <p class="service-subtitle">Software ERP (Enterprise Resource Planning)<br>Facile, Potente e
                                Personalizzato.<br>In una sola parola, <strong>SMART</strong>.</p>
                        </div>
                        <a href="#" class="service-btn">SCOPRI</a>
                    </div>
                </div>

                <!-- Web Solutions Card -->
                <div class="service-card web-card">
                    <div class="service-content">
                        <div>
                            <h2 class="service-title">WEBSITE & WEB-SOLUTIONS</h2>
                            <p class="service-subtitle">Catch the world.<br>Siti web e e-commerce<br>per la tua azienda
                            </p>
                            <div class="service-description">
                                <p>Softwarengineering, specializzata anche nella realizzazione di Siti Web e Internet
                                    per le aziende di Perugia e dell'Umbria, ha tra gli obiettivi, quello di fornire ai
                                    propri clienti una vasta gamma di prodotti per il Web. Siti statici ad uso
                                    prevalentemente personale o ludico, siti aziendali statici o dinamici, per arrivare
                                    a soluzioni piÃ¹ complesse e strutturate come l'e-commerce e i portali di servizi
                                    web.</p>
                                <p><strong>ProfessionalitÃ  ed esperienza al tuo servizio.</strong></p>
                            </div>
                        </div>
                        <a href="#" class="service-btn">SCOPRI</a>
                    </div>
                    <div class="service-image web-image"></div>
                </div>

                <!-- Consulting Card -->
                <div class="service-card consulting-card">
                    <div class="service-content">
                        <div>
                            <h2 class="service-title">Consulenza IT</h2>
                            <p class="service-subtitle">Forti Insieme!<br>Mettiamo insieme le nostre forze<br>Tutta la
                                nostra esperienza e la nostra passione al tuo servizio</p>
                            <div class="service-description">
                                <p>La consulenza informatica diventa sempre piÃ¹ fondamentale per lo sviluppo di
                                    un'azienda. Softwarengineering ti permetteri avvalerti di un ingegnere
                                    informatico capace di consigliarti su come utilizzare le tecnologie
                                    dell'informazione al fine di raggiungere i tuoi obiettivi aziendali.</p>
                                <p>La consulenza informatica Ã¨ finalizzata a proporre principalmente:</p>
                                <p>- Strategie IT o per la sicurezza informatica;<br>- Implementare un sistema ERP o per
                                    selezionare un sistema IT;</p>
                            </div>
                        </div>
                        <a href="#" class="service-btn">SCOPRI</a>
                    </div>
                    <div class="service-image consulting-image"></div>
                </div>

                <!-- Training Card -->
                <div class="service-card training-card">
                    <div class="service-content">
                        <div>
                            <h2 class="service-title">Formazione</h2>
                            <p class="service-subtitle">Amplia i tuoi orizzonti.<br>Formazione & Conoscenza al tuo
                                servizio</p>
                            <div class="service-description">
                                <p>Corsi di formazione sia sul software creato appositamente per i propri clienti, che

                                    e fluiditdi utilizzo migliore. Si effettuano anche corsi sui software piÃ¹
                                    diffusi in commercio (quali Microsoft Word, Microsoft Excel, Microsoft Access,
                                    Microsoft Outlook, Openoffice, Firefox, Windows, etc.)</p>
                            </div>
                        </div>
                        <a href="#" class="service-btn">SCOPRI</a>
                    </div>
                    <div class="service-image training-image"></div>
                </div>
            </div>
        </section>

        <section class="quote-section blue">
            <div style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
                <p>"In Softwarengineering abbiamo trovato un alleato in grado di guidare le nostre scelte nel complesso
                    mondo dell'informatica"</p>
            </div>
        </section>

        <section class="quote-section green">
            <div style="max-width: 800px; margin: 0 auto; padding: 0 20px;">
                <p>"Dai un pesce a un uomo e lo nutrirai per un giorno.<br>Insegnagli a pescare e lo nutrirai per tutta
                    la vita"</p>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div>
            <p>&copy; 2024 Softwarengineering. Tutti i diritti riservati.</p>
            <p>Prodotti, Servizi e Assistenza Informatica</p>
        </div>
    </footer>

    <script>
        function goToUserPage() {
            // Qui puoi cambiare l'URL della pagina utente che creerai
            window.location.href = 'login.php';
            // oppure per aprire in una nuova scheda:
            // window.open('user-page.html', '_blank');
        }

        // Smooth scroll per i link del menu
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>