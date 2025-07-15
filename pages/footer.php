</div>
</div>

<script src="/Office/Browz Invoice/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/Office/Browz Invoice/assets/js/bootstrap.bundle.min.js"></script>

<!-- <script src="/Office/Browz Invoice/assets/vendors/apexcharts/apexcharts.js"></script> -->
<!-- <script src="/Office/Browz Invoice/assets/js/pages/dashboard.js"></script> -->

<script src="/Office/Browz Invoice/assets/js/main.js"></script>

<!-- table cdn  -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>


<!-- select search filter cdn by select2 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script> -->


<!-- active nav  -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll(".submenu-item a");
        // console.log(currentPath);
        // console.log(navLinks);

        navLinks.forEach(link => {
            const linkPage = link.getAttribute("href");
            // console.log(linkPage);
            const linkParent = link.parentNode;
            const superParent = linkParent.parentNode;
            // console.log(linkParent);
            if (linkPage === currentPath || (linkPage === "index.html" && currentPath === "")) {
                // console.log('link match');
                linkParent.classList.add('active');
                superParent.style.display = 'block';
            } else {
                // linkParent.classList.remove('active');
            }
        });
    });
</script>

<!-- <script>
    // dropdown for states and cities
    const indianLocations = {
        states: {
            "Andhra Pradesh": [
                "Amaravati", "Visakhapatnam", "Vijayawada", "Guntur", "Tirupati",
                "Kurnool", "Nellore", "Rajahmundry", "Kakinada", "Anantapur", "Eluru", "Other"
            ],
            "Arunachal Pradesh": [
                "Itanagar", "Tawang", "Pasighat", "Ziro", "Naharlagun",
                "Bomdila", "Khonsa", "Roing", "Longding", "Koloriang", "Other"
            ],
            "Assam": [
                "Dispur", "Guwahati", "Dibrugarh", "Tezpur", "Silchar",
                "Jorhat", "Nagaon", "Barpeta", "Diphu", "Tinsukia", "Goalpara", "Other"
            ],
            "Bihar": [
                "Patna", "Gaya", "Bhagalpur", "Darbhanga", "Muzaffarpur",
                "Purnia", "Bihar Sharif", "Katihar", "Begusarai", "Ara", "Chapra", "Other"
            ],
            "Chhattisgarh": [
                "Raipur", "Bilaspur", "Durg", "Korba", "Bhilai",
                "Jagdalpur", "Rajnandgaon", "Ambikapur", "Raigarh", "Bhatapara", "Other"
            ],
            "Goa": [
                "Panaji", "Vasco-da-Gama", "Margao", "Mapusa", "Ponda",
                "Bicholim", "Sanquelim", "Quepem", "Curchorem", "Chapora", "Other"
            ],
            "Gujarat": [
                "Gandhinagar", "Ahmedabad", "Surat", "Vadodara", "Rajkot",
                "Bhavnagar", "Jamnagar", "Junagadh", "Anand", "Nadiad", "Porbandar", "Other"
            ],
            "Haryana": [
                "Chandigarh", "Faridabad", "Gurgaon", "Panipat", "Ambala",
                "Yamunanagar", "Rohtak", "Hisar", "Karnal", "Bahadurgarh", "Sonipat", "Other"
            ],
            "Himachal Pradesh": [
                "Shimla", "Dharamshala", "Mandi", "Solan", "Kullu",
                "Manali", "Chamba", "Una", "Palampur", "Hamirpur", "Sirmaur", "Other"
            ],
            "Jharkhand": [
                "Ranchi", "Jamshedpur", "Bokaro", "Dhanbad", "Deoghar",
                "Hazaribagh", "Giridih", "Rourkela", "Medininagar", "Chaibasa", "Kodarma", "Other"
            ],
            "Karnataka": [
                "Bengaluru", "Mysuru", "Mangaluru", "Hubballi", "Belagavi",
                "Kalaburagi", "Davangere", "Ballari", "Shimoga", "Tumkur", "Bijapur", "Other"
            ],
            "Kerala": [
                "Thiruvananthapuram", "Kochi", "Kozhikode", "Thrissur", "Kollam",
                "Alappuzha", "Kannur", "Palakkad", "Malappuram", "Thrippunithura", "Kottayam", "Other"
            ],
            "Madhya Pradesh": [
                "Bhopal", "Indore", "Gwalior", "Jabalpur", "Ujjain",
                "Ratlam", "Sagar", "Satna", "Rewa", "Dewas", "Bhind", "Other"
            ],
            "Maharashtra": [
                "Mumbai", "Pune", "Nagpur", "Nashik", "Aurangabad",
                "Thane", "Solapur", "Kolhapur", "Amravati", "Nanded", "Kalyan", "Other"
            ],
            "Manipur": [
                "Imphal", "Bishnupur", "Thoubal", "Churachandpur", "Ukhrul",
                "Senapati", "Tamenglong", "Jiribam", "Kangpokpi", "Kakching", "Other"
            ],
            "Meghalaya": [
                "Shillong", "Tura", "Jowai", "Nongpoh", "Williamnagar",
                "Resubelpara", "Pynthorumkhrah", "Mawkyrwat", "Baghmara", "Baghmor", "Other"
            ],
            "Mizoram": [
                "Aizawl", "Lunglei", "Champhai", "Serchhip", "Kolasib",
                "Saiha", "Lawngtlai", "Champhai", "Mamit", "Siaha", "Khawzawl", "Other"
            ],
            "Nagaland": [
                "Kohima", "Dimapur", "Mokokchung", "Tuensang", "Wokha",
                "Zunheboto", "Phek", "Mon", "Kiphire", "Tseminyu", "Longleng", "Other"
            ],
            "Odisha": [
                "Bhubaneswar", "Cuttack", "Rourkela", "Puri", "Sambalpur",
                "Berhampur", "Balasore", "Baripada", "Bhadrak", "Jharsuguda", "Koraput", "Other"
            ],
            "Punjab": [
                "Chandigarh", "Amritsar", "Jalandhar", "Ludhiana", "Patiala",
                "Bathinda", "Mohali", "Pathankot", "Hoshiarpur", "Moga", "Firozpur", "Other"
            ],
            "Rajasthan": [
                "Jaipur", "Jodhpur", "Udaipur", "Bikaner", "Ajmer",
                "Kota", "Alwar", "Bhilwara", "Sikar", "Bharatpur", "Barmer", "Other"
            ],
            "Sikkim": [
                "Gangtok", "Namchi", "Mangan", "Geyzing", "Ravangla",
                "Namthang", "Pakyong", "Jorethang", "Yuksom", "Yangang", "Other"
            ],
            "Tamil Nadu": [
                "Chennai", "Madurai", "Coimbatore", "Tiruchirapalli", "Salem",
                "Tiruppur", "Thoothukudi", "Erode", "Vellore", "Thanjavur", "Nagercoil", "Other"
            ],
            "Telangana": [
                "Hyderabad", "Warangal", "Nizamabad", "Karimnagar", "Khammam",
                "Ramagundam", "Mahbubnagar", "Nalgonda", "Adilabad", "Siddipet", "Miryalaguda", "Other"
            ],
            "Tripura": [
                "Agartala", "Udaipur", "Kamalpur", "Dharmanagar", "Sonamura",
                "Belonia", "Ambassa", "Kailashahar", "Teliamura", "Sabroom", "Khowai", "Other"
            ],
            "Uttar Pradesh": [
                "Lucknow", "Kanpur", "Agra", "Varanasi", "Noida",
                "Ghaziabad", "Meerut", "Allahabad", "Bareilly", "Aligarh", "Saharanpur", "Other"
            ],
            "Uttarakhand": [
                "Dehradun", "Haridwar", "Roorkee", "Rishikesh", "Nainital",
                "Kotdwar", "Haldwani", "Bhimtal", "Ramnagar", "Srinagar (UK)", "Pithoragarh", "Other"
            ],
            "West Bengal": [
                "Kolkata", "Darjeeling", "Siliguri", "Asansol", "Durgapur",
                "Howrah", "Berhampore", "Malda", "Kharagpur", "Kalyani", "Bardhaman", "Other"
            ]
        },
        unionTerritories: {
            "Andaman and Nicobar Islands": [
                "Port Blair", "Diglipur", "Mayabunder", "Neil Island", "Havelock Island",
                "Campbell Bay", "Car Nicobar", "Swaraj Dweep", "Ross Island", "Little Andaman", "Other"
            ],
            "Chandigarh": ["Chandigarh"],
            "Dadra and Nagar Haveli and Daman and Diu": [
                "Daman", "Diu", "Silvassa", "Kachigam", "Nani Daman",
                "Moti Daman", "Dadra", "Amal", "Rajpipla", "Gandeva", "Other"
            ],
            "Delhi": [
                "New Delhi", "Central Delhi", "North Delhi", "South Delhi", "East Delhi",
                "West Delhi", "North East Delhi", "Shahdara", "Dwarka", "Rohini", "Pitampura", "Other"
            ],
            "Jammu and Kashmir": [
                "Srinagar", "Jammu", "Anantnag", "Baramulla", "Kupwara",
                "Pahalgam", "Katra", "Udhampur", "Rajouri", "Sopore", "Kathua", "Other"
            ],
            "Ladakh": [
                "Leh", "Kargil", "Diskit", "Saspol", "Padum",
                "Khaltsi", "Hunder", "Nimmu", "Nyoma", "Zanskar", "Other"
            ],
            "Lakshadweep": [
                "Kavaratti", "Agatti", "Kadmat", "Minicoy", "Amini",
                "Bangaram", "Chetlat", "Andrott", "Kiltan", "Bitra", "Other"
            ],
            "Puducherry": [
                "Puducherry", "Karaikal", "Mahe", "Yanam", "Oulgaret",
                "Villianur", "Mannadipet", "Bahour", "Ariyankuppam", "Kottakuppam", "Other"
            ]
        }
    };



    // Populate state dropdown
    const stateSelect = document.getElementById("state");
    const citySelect = document.getElementById("city");
    const city = citySelect.value;

    const allRegions = {
        ...indianLocations.states,
        ...indianLocations.unionTerritories
    };

    for (let region in allRegions) {
        const option = document.createElement("option");
        option.value = region;
        option.textContent = region;
        stateSelect.appendChild(option);
    }

    function populateCities() {
        citySelect.innerHTML = '<option value=""></option>';
        const selectedState = stateSelect.value;
        // console.log(selectedState);

        if (selectedState && allRegions[selectedState]) {
            allRegions[selectedState].forEach(city => {
                const option = document.createElement("option");
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }

        citySelect.value = city;
    }

    populateCities();
</script> -->


<!-- <script>
    function changeSearchText() {
        let el = document.querySelector('.dt-search label');
        el.innerHTML = el.innerHTML.replace(
            'Search:',
            '<i class="fa-solid fa-magnifying-glass"></i>'
        );
    }
    setTimeout(() => {
        changeSearchText();
    }, 100);
</script> -->

</body>

</html>