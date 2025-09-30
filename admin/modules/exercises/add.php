                      <?php 
                         if (!isset($_SESSION['USERID'])){
                              redirect(web_root."admin/index.php");
                             }

                      // $autonum = New Autonumber();
                      // $res = $autonum->single_autonumber(2);

                       ?> 
                     <form class="form-horizontal span6" action="controller.php?action=add" method="POST" style="margin-top: 20px;"> 
                        <div class="row">
                           <div class="col-lg-12">
                              <h1 class="page-header">Add New Question</h1>
                            </div>
                            <!-- /.col-lg-12 -->
                         </div>

                        <!-- AI Question Generator Section -->
                        <div class="form-group" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                            <div class="col-md-12">
                                <h4><i class="fa fa-magic"></i> AI Question Generator</h4>
                                <p class="text-muted" style="margin-bottom: 15px;">
                                    <i class="fa fa-info-circle"></i> 
                                    Tự động tạo câu hỏi trắc nghiệm bằng AI. Chỉ cần nhập chủ đề và chọn độ khó!
                                </p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="topic">Chủ đề/Môn học:</label>
                                        <input type="text" class="form-control" id="topic" placeholder="Ví dụ: JavaScript, Toán học, Khoa học..." value="">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="difficulty">Độ khó:</label>
                                        <select class="form-control" id="difficulty">
                                            <option value="dễ">Dễ</option>
                                            <option value="trung bình" selected>Trung bình</option>
                                            <option value="khó">Khó</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="numQuestions">Số lượng câu hỏi:</label>
                                        <select class="form-control" id="numQuestions">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label>&nbsp;</label><br>
                                        <button type="button" class="btn btn-success" id="generateQuestion">
                                            <i class="fa fa-magic"></i> Tạo Câu Hỏi
                                        </button>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-md-12">
                                        <div id="loadingIndicator" style="display: none;">
                                            <i class="fa fa-spinner fa-spin"></i> Đang tạo câu hỏi với AI...
                                        </div>
                                        <div id="aiError" class="alert alert-danger" style="display: none;"></div>
                                        
                                        <!-- Multiple Questions Result Section -->
                                        <div id="multipleQuestionsSection" style="display: none; margin-top: 20px;">
                                            <h5><i class="fa fa-list"></i> Câu hỏi đã tạo:</h5>
                                            <div id="questionsList" class="panel-group" style="margin-top: 15px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "Lesson">Select Lesson:</label>

                          <div class="col-md-8"> 
                            <select class="form-control" name="Lesson" id="Lesson">
                              <?php 
                               $sql = "SELECT * FROM `tbllesson`";
                               $mydb->setQuery($sql);
                               $cur = $mydb->loadResultList();
                               foreach ($cur as $res) {
                                 # code...
                                echo '<option value='.$res->LessonID.'>'.$res->LessonTitle.'</option>';
                               }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div> 
                       <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "Question">Question:</label>

                          <div class="col-md-8">
                            <textarea  class="form-control input-sm" id="Question" name="Question" placeholder=
                                "Question Name" type="text"></textarea>
                            
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceA">A:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceA" name="ChoiceA" placeholder=
                                "" type="text" value="">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceB">B:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceB" name="ChoiceB" placeholder=
                                "" type="text" value="" required>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceC">C:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="ChoiceC" name="ChoiceC" placeholder=
                                "" type="text" value="" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "ChoiceD">D:</label>

                          <div class="col-md-8">
                              <input class="form-control input-sm" id="ChoiceD" name="ChoiceD" placeholder=
                                "" type="text" value="" required>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "Answer">Answer:</label>

                          <div class="col-md-8">
                            
                             <input class="form-control input-sm" id="Answer" name="Answer" placeholder=
                                "Answer" type="text" value="" required>
                          </div>
                        </div>
                      </div> 

                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for=
                          "idno"></label>

                          <div class="col-md-8">
                           <button class="btn btn-primary btn-sm" name="save" type="submit" ><span class="fa fa-save fw-fa"></span>  Save</button> 
                           <button type="button" class="btn btn-default btn-sm" onclick="clearForm()">
                               <span class="fa fa-refresh"></span> Clear Form
                           </button>
                           </div>
                        </div>
                      </div> 
                      </form>

<!-- API Configuration removed - now using hardcoded API key -->

<style>
#multipleQuestionsSection {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border: 1px solid #dee2e6;
}

#multipleQuestionsSection h5 {
    color: #495057;
    margin-bottom: 15px;
}

.panel {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.panel:hover {
    box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.panel-heading {
    background-color: #e9ecef;
    border-bottom: 1px solid #dee2e6;
    border-radius: 6px 6px 0 0;
    padding: 12px 15px;
}

.panel-body {
    padding: 15px;
    background-color: white;
}

.panel-body p {
    margin-bottom: 8px;
    line-height: 1.4;
}

.btn-sm {
    margin: 0 5px;
}
</style>

<script>
// Gemini API Integration - Simplified version
document.getElementById('generateQuestion').addEventListener('click', function() {
    const topic = document.getElementById('topic').value.trim();
    const difficulty = document.getElementById('difficulty').value;
    const numQuestions = parseInt(document.getElementById('numQuestions').value, 10);
    if (!topic) {
        alert('Vui lòng nhập chủ đề cho câu hỏi.');
        return;
    }
    if (isNaN(numQuestions) || numQuestions < 1 || numQuestions > 10) {
        alert('Số lượng câu hỏi phải từ 1 đến 10.');
        return;
    }
    generateQuestionWithAI(topic, difficulty, numQuestions);
});

async function generateQuestionWithAI(topic, difficulty, numQuestions) {
    const loadingIndicator = document.getElementById('loadingIndicator');
    const errorDiv = document.getElementById('aiError');
    
    // Show loading
    loadingIndicator.style.display = 'block';
    errorDiv.style.display = 'none';

    try {
        // Use test API that tries multiple models (no session required)
        const response = await fetch('gemini_api_test.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topic: topic,
                difficulty: difficulty,
                numQuestions: numQuestions
            })
        });

        // Debug: Get raw response text first
        const responseText = await response.text();
        console.log('Raw response:', responseText);
        
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (parseError) {
            throw new Error('Invalid JSON response: ' + parseError.message + '. Response: ' + responseText.substring(0, 200));
        }

        if (!response.ok) {
            throw new Error(result.error || `Lỗi server: ${response.status}`);
        }

        if (!result.success) {
            throw new Error(result.error || 'Không thể tạo câu hỏi');
        }
        
        // Handle response based on number of questions
        if (result.count && result.count > 1) {
            // Multiple questions - show selection interface
            displayMultipleQuestions(result.data, result.count);
        } else {
            // Single question - fill form directly
            const questionData = Array.isArray(result.data) ? result.data[0] : result.data;
            fillFormWithQuestionData(questionData);
            showSuccessMessage('Tạo câu hỏi thành công! Vui lòng kiểm tra và chỉnh sửa nếu cần.');
        }
        
        loadingIndicator.style.display = 'none';
        
    } catch (error) {
        console.error('Error generating question:', error);
        errorDiv.innerHTML = `<strong>Lỗi:</strong> ${error.message}`;
        errorDiv.style.display = 'block';
        loadingIndicator.style.display = 'none';
    }
}

function extractQuestionData(text) {
    // Fallback method to extract question data if JSON parsing fails
    const lines = text.split('\n');
    let questionData = {
        question: '',
        choices: { A: '', B: '', C: '', D: '' },
        answer: 'A'
    };
    
    // Simple extraction logic - this is a fallback
    for (let line of lines) {
        if (line.includes('question') && line.includes(':')) {
            questionData.question = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"A"') && line.includes(':')) {
            questionData.choices.A = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"B"') && line.includes(':')) {
            questionData.choices.B = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"C"') && line.includes(':')) {
            questionData.choices.C = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('"D"') && line.includes(':')) {
            questionData.choices.D = line.split(':')[1].replace(/['"]/g, '').trim();
        }
        if (line.includes('answer') && line.includes(':')) {
            questionData.answer = line.split(':')[1].replace(/['"]/g, '').trim();
        }
    }
    
    return questionData;
}

function displayMultipleQuestions(questions, count) {
    const multipleSection = document.getElementById('multipleQuestionsSection');
    const questionsList = document.getElementById('questionsList');
    
    // Clear previous results
    questionsList.innerHTML = '';
    
    // Create question cards
    questions.forEach((question, index) => {
        const questionCard = document.createElement('div');
        questionCard.className = 'panel panel-default';
        questionCard.style.marginBottom = '15px';
        
        questionCard.innerHTML = `
            <div class="panel-heading">
                <h6 class="panel-title">
                    <strong>Câu hỏi ${index + 1}:</strong> ${question.question}
                </h6>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>A:</strong> ${question.choices.A}</p>
                        <p><strong>B:</strong> ${question.choices.B}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>C:</strong> ${question.choices.C}</p>
                        <p><strong>D:</strong> ${question.choices.D}</p>
                        <p><strong style="color: green;">Đáp án đúng:</strong> ${question.answer}</p>
                    </div>
                </div>
                <div class="text-center" style="margin-top: 15px;">
                    <button type="button" class="btn btn-primary btn-sm" onclick="useThisQuestion(${index})">
                        <i class="fa fa-check"></i> Sử dụng câu hỏi này
                    </button>
                    <button type="button" class="btn btn-info btn-sm" onclick="copyQuestionText(${index})">
                        <i class="fa fa-copy"></i> Copy câu hỏi
                    </button>
                </div>
            </div>
        `;
        
        questionsList.appendChild(questionCard);
    });
    
    // Store questions globally for use in button handlers
    window.generatedQuestions = questions;
    
    // Show the section
    multipleSection.style.display = 'block';
    
    // Show success message
    showSuccessMessage(`Tạo thành công ${count} câu hỏi! Chọn câu hỏi bạn muốn sử dụng.`);
}

function useThisQuestion(index) {
    if (window.generatedQuestions && window.generatedQuestions[index]) {
        fillFormWithQuestionData(window.generatedQuestions[index]);
        
        // Scroll to form
        document.getElementById('Question').scrollIntoView({ behavior: 'smooth' });
        
        // Highlight the selected question briefly
        const questionCards = document.querySelectorAll('.panel');
        if (questionCards[index]) {
            questionCards[index].style.backgroundColor = '#d4edda';
            setTimeout(() => {
                questionCards[index].style.backgroundColor = '';
            }, 2000);
        }
        
        showSuccessMessage('Đã điền câu hỏi vào form! Vui lòng kiểm tra và chỉnh sửa nếu cần.');
    }
}

function copyQuestionText(index) {
    if (window.generatedQuestions && window.generatedQuestions[index]) {
        const question = window.generatedQuestions[index];
        const text = `Câu hỏi: ${question.question}
A: ${question.choices.A}
B: ${question.choices.B}
C: ${question.choices.C}
D: ${question.choices.D}
Đáp án: ${question.answer}`;
        
        navigator.clipboard.writeText(text).then(() => {
            showSuccessMessage('Đã copy câu hỏi vào clipboard!');
        }).catch(err => {
            console.error('Could not copy text: ', err);
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showSuccessMessage('Đã copy câu hỏi vào clipboard!');
        });
    }
}

function fillFormWithQuestionData(data) {
    // Fill the form fields
    document.getElementById('Question').value = data.question || '';
    document.getElementById('ChoiceA').value = data.choices.A || '';
    document.getElementById('ChoiceB').value = data.choices.B || '';
    document.getElementById('ChoiceC').value = data.choices.C || '';
    document.getElementById('ChoiceD').value = data.choices.D || '';
    document.getElementById('Answer').value = data.answer || '';
}

function clearForm() {
    document.getElementById('Question').value = '';
    document.getElementById('ChoiceA').value = '';
    document.getElementById('ChoiceB').value = '';
    document.getElementById('ChoiceC').value = '';
    document.getElementById('ChoiceD').value = '';
    document.getElementById('Answer').value = '';
    document.getElementById('topic').value = '';
}

function showSuccessMessage(message) {
    // Create a temporary success alert
    const successDiv = document.createElement('div');
    successDiv.className = 'alert alert-success';
    successDiv.innerHTML = `<i class="fa fa-check"></i> ${message}`;
    successDiv.style.position = 'fixed';
    successDiv.style.top = '20px';
    successDiv.style.right = '20px';
    successDiv.style.zIndex = '9999';
    
    document.body.appendChild(successDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        document.body.removeChild(successDiv);
    }, 3000);
}
</script>