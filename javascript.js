 //--------------
 // Data Storage
 //-------------
        let userData = {
            balance: 5000,
            loyaltyPoints: 260,
            bookings: [],
            transactions: [],
            notifications: [
                { message: 'Welcome to Tickify! Your journey starts here.', time: new Date().toLocaleString(), type: 'info' },
                { message: 'Special offer: Get 20% off on your next booking!', time: new Date().toLocaleString(), type: 'promo' }
            ]
        };
        //----------
       //user Dashboard
       //============
       function goToHidden() {
      window.location.href = 'signup.php'; // Replace with your file
       }
       function showContact() {
        window.location.href = "contact.html";//replace with contact form if php or html... 
      }
      
      function showPrivacy() {
        window.location.href = "privancy and terms.html";
        // This is privancy and Term..
      }
      function showAbout() {
        window.location.href = "privancy and terms.html";
        // This is about the 
      }
        // ----------------------
// PAGE SWITCHING
// ----------------------
function showPage(pageId) {
    const pages = document.querySelectorAll(".page-content");
    pages.forEach(p => p.classList.remove("active"));

    document.getElementById(pageId).classList.add("active");

    window.scrollTo({ top: 0, behavior: "smooth" });

}

function showHome() { showPage("homePage"); }
function showWallet() { showPage("walletPage"); }
function showBookings() { showPage("bookingsPage"); }
function showLoyalty() { showPage("loyaltyPage"); }
function showNotifications() { showPage("notificationsPage"); }
function showSupport() { showPage("supportPage"); }


// ----------------------
// SMOOTH SCROLL (FOOTER + HEADER)
// ----------------------
document.querySelectorAll("a[onclick]").forEach(link => {
    link.addEventListener("click", () => {
        setTimeout(() => window.scrollTo({ top: 0, behavior: "smooth" }), 100);
    });
});


// ----------------------
// BUS SEARCH SCROLL
// ----------------------
function searchBuses() {
    document.getElementById("busResults").scrollIntoView({ behavior: "smooth" });
}

        // Bus routes with fares
const busRoutes = {
         'Nairobi-Mombasa': { fare: 1199, distance: '480 km', duration: '8 hrs' },
        'Nairobi-Kisumu': { fare: 1499, distance: '350 km', duration: '7 hrs' },
        'Nairobi-Nakuru': { fare: 599, distance: '160 km', duration: '3 hrs' },
       'Nairobi-Eldoret': { fare: 999, distance: '320 km', duration: '5.5 hrs' },
       'Mombasa-Kisumu': { fare: 2699, distance: '800 km', duration: '12 hrs' },
       'Mombasa-Nakuru': { fare: 1699, distance: '600 km',  duration: '10 hrs' },
       'Kisumu-Nakuru': { fare: 599, distance: '200 km', duration: '4 hrs' },
       'Kisumu-Eldoret': { fare: 449, distance: '120 km', duration: '2.5 hrs' },
       'Nakuru-Eldoret': { fare: 449, distance: '160 km', duration: '3 hrs' },
       'Nairobi-Ukunda': { fare: 1699, distance: '517 km',  duration: '8 hrs' },
       'Nairobi-Kilifi': { fare: 1899, distance: '524 km', duration: '10 hrs' },
       'Nairobi-Hola': { fare: 1999, distance: '486 km', duration: '8 hrs' },
       'Nairobi-Lamu': { fare: 2999, distance: '737 km', duration: '11 hrs' },
      'Nairobi-Voi': { fare: 799, distance: '330 km', duration: '4.5 hrs' }
   };            
                             

  

            //BUses On website
           //============
          //-----------------
        const busCompanies = [
            { name: 'Metro Express', amenities: 'WiFi, AC, USB Charging' },
            { name: 'Super Highway', amenities: 'AC, Reclining Seats' },
            { name: 'Swift Travel', amenities: 'WiFi, AC, Entertainment' },
            { name: 'Coast Express', amenities: 'AC, Snacks, USB Charging' }
        ];

        let currentBooking = null;
    

        // Initialize date input with today's date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('travelDate').setAttribute('min', today);
            document.getElementById('travelDate').value = today;
            updateWalletDisplay();
            updateLoyaltyDisplay();
            loadNotifications();
        });

        // Navigation Functions
        function showHome() {
            hideAllPages();
            document.getElementById('homePage').classList.add('active');
        }

        function showWallet() {
            hideAllPages();
            document.getElementById('walletPage').classList.add('active');
            loadTransactions();
        }   

        function showBookings() {
            hideAllPages();
            document.getElementById('bookingsPage').classList.add('active');
            loadBookingHistory();
        }

        function showLoyalty() {
            hideAllPages();
            document.getElementById('loyaltyPage').classList.add('active');
            updateLoyaltyDisplay();
        }

        function showNotifications() {
            hideAllPages();
            document.getElementById('notificationsPage').classList.add('active');
            loadNotifications();
        }

        function showSupport() {
            hideAllPages();
            document.getElementById('supportPage').classList.add('active');
        }

        function hideAllPages() {
            const pages = document.querySelectorAll('.page-content');
            pages.forEach(page => page.classList.remove('active'));
        }

        // Search Buses Function
        function searchBuses() {
            const origin = document.getElementById('origin').value;
            const destination = document.getElementById('destination').value;
            const date = document.getElementById('travelDate').value;
            const passengers = document.getElementById('passengers').value;

            if (!origin || !destination || !date) {
                alert('Please fill in all fields');
                return;
            }

            if (origin === destination) {
                alert('Origin and destination cannot be the same');
                return;
            }

            const routeKey1 = `${origin}-${destination}`;
            const routeKey2 = `${destination}-${origin}`;
            const route = busRoutes[routeKey1] || busRoutes[routeKey2];

            if (!route) {
                alert('No routes available for this journey');
                return;
            }

            displayBuses(origin, destination, route, passengers);
        }

        function displayBuses(origin, destination, route, passengers) {
            const busCards = document.getElementById('busCards');
            const busResults = document.getElementById('busResults');
            busCards.innerHTML = '';

            busCompanies.forEach((company, index) => {
                const farePerPerson = route.fare;
                const totalFare = farePerPerson * passengers;
                
                const card = document.createElement('div');
                card.className = 'bus-card';
                card.style.animationDelay = `${index * 0.1}s`;
                card.onclick = function() { selectBus(company.name, origin, destination, totalFare, passengers, route); };
                
                card.innerHTML = `
                    <div class="bus-header">
                        <div class="bus-name">${company.name}</div>
                        <div class="bus-fare">KSh ${totalFare}</div>
                    </div>
                    <div class="bus-route">
                        <div class="route-point">${origin}</div>
                        <div class="route-arrow"></div>
                        <div class="route-point">${destination}</div>
                    </div>
                    <div class="bus-details">
                        <span>🚌 ${route.distance}</span>
                        <span>⏱️ ${route.duration}</span>
                    </div>
                    <div style="margin-top: 0.5rem; color: #666; font-size: 0.9rem;">
                        ${company.amenities}
                    </div>
                    <button class="book-btn" onclick="event.stopPropagation(); selectBus('${company.name}', '${origin}', '${destination}', ${totalFare}, ${passengers}, ${JSON.stringify(route).replace(/"/g, '&quot;')})">Book Now</button>
                `;
                
                busCards.appendChild(card);
            });

            busResults.style.display = 'block';
        }

        function selectBus(busName, origin, destination, totalFare, passengers, route) {
            currentBooking = {
                busName: busName,
                origin: origin,
                destination: destination,
                fare: totalFare,
                passengers: passengers,
                date: document.getElementById('travelDate').value,
                distance: route.distance,
                duration: route.duration
            };

            const bookingDetails = document.getElementById('bookingDetails');
            bookingDetails.innerHTML = `
                <div class="history-item">
                    <h3 style="color: #667eea; margin-bottom: 1rem;">${busName}</h3>
                    <p><strong>Route:</strong> ${origin} → ${destination}</p>
                    <p><strong>Date:</strong> ${currentBooking.date}</p>
                    <p><strong>Passengers:</strong> ${passengers}</p>
                    <p><strong>Distance:</strong> ${route.distance}</p>
                    <p><strong>Duration:</strong> ${route.duration}</p>
                    <p style="font-size: 1.5rem; color: #764ba2; margin-top: 1rem;"><strong>Total Fare: KSh ${totalFare}</strong></p>
                    <p style="margin-top: 0.5rem; color: #666;">Current Balance: KSh ${userData.balance}</p>
                </div>
            `;

            openModal('bookingModal');
        }

  

        //booking
 
         function confirmBooking() {
            if (!currentBooking) return;
            window.location.href = 'mpesa.html';

            
            //Save booking data
            localStorage.setItem('pendingBooking', JSON.stringify(bookingData));
            
             // Store booking data in localStorage or sessionStorage
    const bookingData = {
        amount: currentBooking.fare,
        origin: currentBooking.origin,
        destination: currentBooking.destination,
        busName: currentBooking.busName,
        passengers: currentBooking.passengers,
        date: currentBooking.date,
        distance: currentBooking.distance,
        duration: currentBooking.duration
    };
    

            // Deduct fare
            userData.balance -= currentBooking.fare;



            // Add loyalty points (1 point per 100 KSh)
            const pointsEarned = Math.floor(currentBooking.fare / 100);
            userData.loyaltyPoints += pointsEarned;

            // Generate booking ID
            const bookingId = 'TKF' + Date.now();
            currentBooking.bookingId = bookingId;
            currentBooking.status = 'Confirmed';
            currentBooking.bookingTime = new Date().toLocaleString();

            // Add to bookings
            userData.bookings.unshift(currentBooking);

            // Add transaction
            userData.transactions.unshift({
                type: 'Booking',
                amount: -currentBooking.fare,
                description: `${currentBooking.origin} to ${currentBooking.destination}`,
                date: new Date().toLocaleString(),
                bookingId: bookingId
            });

            // Add notification
            userData.notifications.unshift({
                message: `Booking confirmed! ${currentBooking.busName} from ${currentBooking.origin} to ${currentBooking.destination}. Booking ID: ${bookingId}`,
                time: new Date().toLocaleString(),
                type: 'success'
            });

            updateWalletDisplay();
            updateLoyaltyDisplay();

            closeModal('bookingModal');

            // Show QR code
            document.getElementById('qrBookingId').textContent = bookingId;
            openModal('qrModal');

            
         }
        // Wallet Functions
        function loadFunds() {
            const amount = parseInt(document.getElementById('loadAmount').value);
            if (!amount || amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }

            userData.balance += amount;
            userData.transactions.unshift({
                type: 'Load Funds',
                amount: amount,
                description: 'Wallet top-up',
                date: new Date().toLocaleString()
            });

            userData.notifications.unshift({
                message: `Successfully loaded KSh ${amount} to your wallet.`,
                time: new Date().toLocaleString(),
                type: 'success'
            });

            updateWalletDisplay();
            loadTransactions();
            document.getElementById('loadAmount').value = '';
        }

        function updateWalletDisplay() {
            document.getElementById('walletBalance').textContent = userData.balance;
        }

        function loadTransactions() {
            const transactionsDiv = document.getElementById('transactions');
            if (userData.transactions.length === 0) {
                transactionsDiv.innerHTML = '<p style="text-align: center; color: #999;">No transactions yet</p>';
                return;
            }

            transactionsDiv.innerHTML = userData.transactions.map(t => `
                <div class="history-item">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <strong>${t.type}</strong>
                            <p style="color: #666; font-size: 0.9rem;">${t.description}</p>
                            <p style="color: #999; font-size: 0.85rem; margin-top: 0.3rem;">${t.date}</p>
                        </div>
                        <div style="font-size: 1.2rem; font-weight: 700; color: ${t.amount > 0 ? '#4CAF50' : '#f44336'};">
                            ${t.amount > 0 ? '+' : ''}KSh ${Math.abs(t.amount)}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Booking History
        function loadBookingHistory() {
            const bookingHistory = document.getElementById('bookingHistory');
            if (userData.bookings.length === 0) {
                bookingHistory.innerHTML = '<p style="text-align: center; color: #999;">No bookings yet</p>';
                return;
            }

            bookingHistory.innerHTML = userData.bookings.map(b => `
                <div class="history-item">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                        <strong style="color: #667eea;">${b.busName}</strong>
                        <span style="padding: 0.3rem 0.8rem; background: #4CAF50; color: white; border-radius: 20px; font-size: 0.85rem;">${b.status}</span>
                    </div>
                    <p><strong>Route:</strong> ${b.origin} → ${b.destination}</p>
                    <p><strong>Date:</strong> ${b.date}</p>
                    <p><strong>Passengers:</strong> ${b.passengers}</p>
                    <p><strong>Booking ID:</strong> ${b.bookingId}</p>
                    <p><strong>Fare:</strong> KSh ${b.fare}</p>
                    <p style="color: #999; font-size: 0.85rem; margin-top: 0.5rem;">Booked on: ${b.bookingTime}</p>
                    <button class="book-btn" onclick="viewTicket('${b.bookingId}')">View Ticket</button>
                </div>
            `).join('');
        }

        function viewTicket(bookingId) {
            document.getElementById('qrBookingId').textContent = bookingId;
            openModal('qrModal');
        }

        // Loyalty Functions
        function updateLoyaltyDisplay() {
            document.getElementById('loyaltyPoints').textContent = userData.loyaltyPoints;
        }

        function redeemReward(pointsCost, rewardName) {
            if (userData.loyaltyPoints < pointsCost) {
                alert('Insufficient loyalty points!');
                return;
            }

            if (confirm(`Redeem ${pointsCost} points for ${rewardName}?`)) {
                userData.loyaltyPoints -= pointsCost;
                
                userData.notifications.unshift({
                    message: `Reward redeemed: ${rewardName}. Check your email for the coupon code.`,
                    time: new Date().toLocaleString(),
                    type: 'reward'
                });

                updateLoyaltyDisplay();
                alert(`${rewardName} redeemed successfully! Check your notifications for details.`);
            }
        }

        // Notifications
        function loadNotifications() {
            const notificationsList = document.getElementById('notificationsList');
            if (userData.notifications.length === 0) {
                notificationsList.innerHTML = '<p style="text-align: center; color: #999;">No notifications</p>';
                return;
            }

            notificationsList.innerHTML = userData.notifications.map((n, index) => `
                <div class="notification-item" style="animation-delay: ${index * 0.1}s;">
                    <strong>${n.message}</strong>
                    <div class="notification-time">${n.time}</div>
                </div>
            `).join('');
        }

        // Support Functions
        function submitSupport() {
            const name = document.getElementById('supportName').value;
            const email = document.getElementById('supportEmail').value;
            const message = document.getElementById('supportMessage').value;

            if (!name || !email || !message) {
                alert('Please fill in all fields');
                return;
            }

            userData.notifications.unshift({
                message: `Support ticket submitted. We'll respond to ${email} within 24 hours.`,
                time: new Date().toLocaleString(),
                type: 'info'
            });

            document.getElementById('supportName').value = '';
            document.getElementById('supportEmail').value = '';
            document.getElementById('supportMessage').value = '';
        }

        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Floating Buttons
        function openWhatsApp() {
            window.open('https://wa.me/254769924070?text=Hello%20Tickify!%20I%20need%20assistance.', '_blank');
        }

        function openSMS() {
            window.location.href = 'sms:+254769924070?body=Hello Tickify! I need assistance.';
        }

        // Download Ticket
        function downloadTicket() {
           
        }

        // Update fare display (optional enhancement)
        function updateFare() {
            // This can be enhanced to show estimated fare before search
        }

        //This is where the   QR is GEnerated after payment now connect it to your website

        //Read Query Parameters from URL
        const params = new URLSearchParams(window.location.search);
        const passengerName = params.get("name");
        const seatNumber = params.get("seat");
        const route = params.get("route");
        const price = params.get("price");
        const date = params.get("date");
        const ticketId = params.get("id");

            // Fill ticket info
        document.getElementById("route-info").textContent = `Route: ${route.replace("-", " → ")}`;
        document.getElementById("price-info").textContent = `Price: Ksh ${price}`;
        document.getElementById("date-info").textContent = `Travel Date: ${date}`;
        document.getElementById("passenger-info").textContent = `Passenger: ${passengerName}`;
        document.getElementById("seat-info").textContent = `Seat Number: ${seatNumber}`;
  
         //my new added section
        function showMyNewSection() { 
    showPage("myNewSection"); 
}
        
        //Generate ticket based on user input

                // Mobile Navigation Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const navbarToggler = document.getElementById('navbarToggler');
            const navbarCollapse = document.getElementById('navbarNav');
            
            navbarToggler.addEventListener('click', function() {
                navbarToggler.classList.toggle('active');
                navbarCollapse.classList.toggle('show');
            });
            
            // Close navbar when clicking on a nav link
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        navbarToggler.classList.remove('active');
                        navbarCollapse.classList.remove('show');
                    }
                });
            });
            
            // Close navbar when clicking outside
            document.addEventListener('click', function(event) {
                if (!navbarCollapse.contains(event.target) && !navbarToggler.contains(event.target)) {
                    navbarToggler.classList.remove('active');
                    navbarCollapse.classList.remove('show');
                }
            });
        });
        

                // Toggle FAQ answers
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            answer.classList.toggle('active');
            
            // Rotate chevron icon
            const icon = element.querySelector('i');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }
 
        
  
        
        // Generate QR and download ticket with all details
function downloadTicket() {
    const ticketId = document.getElementById('qrBookingId').textContent;
    const passengerName = document.getElementById('passenger-info').textContent.replace('Passenger: ', '');
    const seatNumber = document.getElementById('seat-info').textContent.replace('Seat Number: ', '');
    const route = document.getElementById('route-info').textContent.replace('Route: ', '');
    const date = document.getElementById('date-info').textContent.replace('Travel Date: ', '');
    const price = document.getElementById('price-info').textContent.replace('Price: Ksh ', '');

    // Create temporary ticket div
    const ticketDiv = document.createElement('div');
    ticketDiv.id = 'tempTicket';
    ticketDiv.style.width = '400px';
    ticketDiv.style.padding = '20px';
    ticketDiv.style.fontFamily = 'Arial, sans-serif';
    ticketDiv.style.border = '2px solid #667eea';
    ticketDiv.style.borderRadius = '10px';
    ticketDiv.style.backgroundColor = '#fff';
    ticketDiv.style.textAlign = 'center';
    ticketDiv.style.position = 'relative';

    ticketDiv.innerHTML = `
        <h2 style="color:#667eea;">🎫Tickify Ticket</h2>
        <p><strong>Booking ID:</strong> ${ticketId}</p>
        <p><strong>Passenger:</strong> ${passengerName}</p>
        <p><strong>Seat Number:</strong> ${seatNumber}</p>
        <p><strong>Route:</strong> ${route}</p>
        <p><strong>Date:</strong> ${date}</p>
        <p><strong>Fare:</strong> KSh ${price}</p>
        <div id="ticketQR" style="margin-top:20px; position: relative; display: inline-block;"></div>
    `;

    document.body.appendChild(ticketDiv); // Temporarily add to DOM

    // Generate QR code inside ticket
    const qrContainer = document.getElementById('ticketQR');
    //Generate QR Code With center Tickify Logo
    const qrCanvas = document.createElement('canvas');
    qrContainer.appendChild(qrCanvas);

     QRCode.toCanvas(qrCanvas, `https://tickify.co.ke/ticket/${ticketId}`, { width: 200 }, function(error) {
        if (error) console.error(error);

        //overLay Tickify Logo At Center Of QR " is not made already after making logo add it."
        

        // After QR + logo is ready, capture the ticket as an image
        html2canvas(ticketDiv).then(canvas => {
            const link = document.createElement('a');
            link.download = `Tickify_${ticketId}.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();

            // Remove temporary ticket div after download
            ticketDiv.remove();
        });
    });
}
// Calculate fare function
function calculateFare() {
    // This would calculate fare based on origin, destination and passengers
    // For now, we'll just show a placeholder
    document.getElementById('estimated-fare').textContent = 'KSh 0';
}





