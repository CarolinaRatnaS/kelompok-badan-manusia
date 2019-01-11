<?php include("includes/header.php"); ?>

    <!-- Page Content -->
    <div class="container">

      <h1 class="my-4 text-center text-lg-center">Kuis Bagian Tubuh manusia</h1>
      <br />

      <div id="quiz"></div>
        <div class="button" id="next"><a href="#">Selanjutnya</a></div>
        <div class="button" id="prev"><a href="#">Sebelumnya</a></div>
        <div class="button" id="start"> <a href="#">Coba lagi</a></div>

    </div>
    <!-- /.container -->

<!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Kelompok Bagian Tubuh Manusia - 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <script src="https://www.gstatic.com/firebasejs/5.7.2/firebase.js"></script>
    <script>
      // Initialize Firebase
      var config = {
        apiKey: "AIzaSyCwjxqyMKXvtAPM3n9kV0a6P3_J7Q12_YI",
        authDomain: "elearning-bagian-tubuh-manusia.firebaseapp.com",
        databaseURL: "https://elearning-bagian-tubuh-manusia.firebaseio.com",
        projectId: "elearning-bagian-tubuh-manusia",
        storageBucket: "",
        messagingSenderId: "699639238438"
      };
      firebase.initializeApp(config);
    </script>
    
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
          (function() {
      var questions = [{
        question: "Apakah yang disebut dengan lekukan kecil pada pipi?",
        choices: ["Telinga", "Lesung pipi", "Lubang hidung", "Kumis", "Alis mata"],
        correctAnswer: 1
      }, {
        question: "Tenggorokan merupakan bagian tubuh di ....",
        choices: ["Bagian Dalam", "Bagian Umum", "Bagian kepala", "Bagian badan atas", "Bagian badan bawah"],
        correctAnswer: 3
      }, {
        question: "Bagian tubuh manusia yang berfungsi menghubungkan antara perut dan pinggul adalah?",
        choices: ["Pinggang", "Panggul", "Pantat", "Siku", "Betis"],
        correctAnswer: 0
      }, {
        question: "Manakah yang berfungsi membentuk sendi peluru dengan tulang pengumpil dan sendi engsel dengan tulang hasta?",
        choices: ["Pergelangan tangan", "Lengan atas", "Jari", "Lengan bawah", "Telapak tangan"],
        correctAnswer: 3
      }, {
        question: "Pori-pori berufungsi untuk?",
        choices: ["Membentuk sendi peluru dengan tulang belikat.", "Menahan beban saat memikul.", "Bantalan ketika kita duduk.", "Menutupi rangka tubuh kita.", "Mengeluarkan zat-zat sisa metabolisme tubuh."],
        correctAnswer: 4
      }];
      
      var questionCounter = 0; //Tracks question number
      var selections = []; //Array containing user choices
      var quiz = $('#quiz'); //Quiz div object
      
      // Display initial question
      displayNext();
      
      // Click handler for the 'next' button
      $('#next').on('click', function (e) {
        e.preventDefault();
        
        // Suspend click listener during fade animation
        if(quiz.is(':animated')) {        
          return false;
        }
        choose();
        
        // If no user selection, progress is stopped
        if (isNaN(selections[questionCounter])) {
          alert('Ayo dipilih dulu dong jawabannya!');
        } else {
          questionCounter++;
          displayNext();
        }
      });
      
      // Click handler for the 'prev' button
      $('#prev').on('click', function (e) {
        e.preventDefault();
        
        if(quiz.is(':animated')) {
          return false;
        }
        choose();
        questionCounter--;
        displayNext();
      });
      
      // Click handler for the 'Start Over' button
      $('#start').on('click', function (e) {
        e.preventDefault();
        
        if(quiz.is(':animated')) {
          return false;
        }
        questionCounter = 0;
        selections = [];
        displayNext();
        $('#start').hide();
      });
      
      // Animates buttons on hover
      $('.button').on('mouseenter', function () {
        $(this).addClass('active');
      });
      $('.button').on('mouseleave', function () {
        $(this).removeClass('active');
      });
      
      // Creates and returns the div that contains the questions and 
      // the answer selections
      function createQuestionElement(index) {
        var qElement = $('<div>', {
          id: 'question'
        });
        
        var header = $('<h2>Question ' + (index + 1) + ':</h2>');
        qElement.append(header);
        
        var question = $('<p>').append(questions[index].question);
        qElement.append(question);
        
        var radioButtons = createRadios(index);
        qElement.append(radioButtons);
        
        return qElement;
      }
      
      // Creates a list of the answer choices as radio inputs
      function createRadios(index) {
        var radioList = $('<ul style="list-style-type: none;">');
        var item;
        var input = '';
        for (var i = 0; i < questions[index].choices.length; i++) {
          item = $('<li>');
          input = '<input type="radio" name="answer" value=' + i + ' />';
          input += questions[index].choices[i];
          item.append(input);
          radioList.append(item);
        }
        return radioList;
      }
      
      // Reads the user selection and pushes the value to an array
      function choose() {
        selections[questionCounter] = +$('input[name="answer"]:checked').val();
      }
      
      // Displays next requested element
      function displayNext() {
        quiz.fadeOut(function() {
          $('#question').remove();
          
          if(questionCounter < questions.length){
            var nextQuestion = createQuestionElement(questionCounter);
            quiz.append(nextQuestion).fadeIn();
            if (!(isNaN(selections[questionCounter]))) {
              $('input[value='+selections[questionCounter]+']').prop('checked', true);
            }
            
            // Controls display of 'prev' button
            if(questionCounter === 1){
              $('#prev').show();
            } else if(questionCounter === 0){
              
              $('#prev').hide();
              $('#next').show();
            }
          }else {
            var scoreElem = displayScore();
            quiz.append(scoreElem).fadeIn();
            $('#next').hide();
            $('#prev').hide();
            $('#start').show();
          }
        });
      }
      
      // Computes score and returns a paragraph element to be displayed
      function displayScore() {
        var score = $('<p>',{id: 'question'});
        
        var numCorrect = 0;
        for (var i = 0; i < selections.length; i++) {
          if (selections[i] === questions[i].correctAnswer) {
            numCorrect++;
          }
        }
        
        score.append('You got ' + numCorrect + ' questions out of ' +
                     questions.length + ' right!!!');
        return score;
      }
    })();
    </script>

  </body>

</html>
