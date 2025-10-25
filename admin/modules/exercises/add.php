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
                                        <label for="aiTopic">AI Topic (auto-filled):</label>
                                        <input type="text" class="form-control" id="aiTopic" placeholder="Chọn Category và Topic trước" readonly style="background-color: #f5f5f5;">
                                        <small class="text-muted">Sẽ tự động điền khi bạn chọn Category và Topic</small>
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
                                        
                                        <!-- Info message for bulk operations -->
                                        <div id="bulkInfoMessage" class="alert alert-info" style="margin-top: 15px;">
                                            <i class="fa fa-info-circle"></i> 
                                            <strong>Hướng dẫn Bulk Insert:</strong> 
                                            Nhập chủ đề và click "Tạo Câu Hỏi" để AI tạo nhiều câu hỏi, sau đó bạn có thể chọn "Select All" và "Insert Selected" để thêm nhiều câu cùng lúc.
                                        </div>
                                        
                                        <!-- Multiple Questions Result Section -->
                                        <div id="multipleQuestionsSection" style="display: none; margin-top: 20px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h5><i class="fa fa-list"></i> Câu hỏi đã tạo: <span id="questionCount">0</span></h5>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <div class="btn-group" style="margin-bottom: 15px;">
                                                        <button type="button" class="btn btn-default btn-sm" id="selectAllQuestions">
                                                            <i class="fa fa-check-square-o"></i> Select All
                                                        </button>
                                                        <button type="button" class="btn btn-default btn-sm" id="deselectAllQuestions">
                                                            <i class="fa fa-square-o"></i> Deselect All
                                                        </button>
                                                        <button type="button" class="btn btn-success btn-sm" id="bulkInsertQuestions" disabled>
                                                            <i class="fa fa-plus-circle"></i> Insert Selected (<span id="selectedCount">0</span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="questionsList" class="panel-group" style="margin-top: 15px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for="Category">Category:</label>
                          <div class="col-md-8"> 
                            <select class="form-control" name="Category" id="Category" required onchange="loadTopics()">
                                <option value="">Select Category</option>
                                <?php
                                $sql = "SELECT * FROM tblcategories WHERE IsActive = 1 ORDER BY CategoryName";
                                $mydb->setQuery($sql);
                                $categories = $mydb->loadResultList();
                                foreach ($categories as $category) {
                                    echo '<option value="'.$category->CategoryID.'">'.$category->CategoryName.'</option>';
                                }
                                ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-md-8">
                          <label class="col-md-4 control-label" for="Topic">Topic:</label>
                          <div class="col-md-8"> 
                            <select class="form-control" name="Topic" id="Topic" required>
                                <option value="">Select Category first</option>
                            </select>
                            <small class="help-block text-muted">
                                <i class="fa fa-info-circle"></i> 
                                Chọn category trước, sau đó chọn topic cụ thể
                            </small>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <div class="col-md-8">
                          <div class="col-md-offset-4 col-md-8">
                            <a href="index.php?view=categories" class="btn btn-info btn-sm">
                                <i class="fa fa-cog"></i> Manage Categories & Topics
                            </a>
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

.question-card {
    transition: all 0.3s ease;
}

.question-card.selected {
    background-color: #e8f5e8 !important;
    border-color: #28a745 !important;
    border-width: 2px !important;
}

.question-selector {
    transform: scale(1.3);
    margin-right: 10px;
}

.question-selector:checked {
    accent-color: #28a745;
}

#bulkInsertQuestions:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

#bulkInsertQuestions:not(:disabled) {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.panel-heading label {
    font-weight: normal;
    width: 100%;
    margin: 0;
}

.panel-heading input[type="checkbox"] {
    margin-right: 8px;
}

#questionCount {
    color: #007bff;
    font-weight: bold;
}
</style>

<script>
// Gemini API Integration - Simplified version
// Add event listener for Topic select
document.getElementById('Topic').addEventListener('change', updateAITopic);

document.getElementById('generateQuestion').addEventListener('click', function() {
    const topic = document.getElementById('aiTopic').value.trim();
    const difficulty = document.getElementById('difficulty').value;
    const numQuestions = parseInt(document.getElementById('numQuestions').value, 10);
    
    if (!topic) {
        alert('Vui lòng chọn Category và Topic trước khi tạo câu hỏi.');
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
    const questionCount = document.getElementById('questionCount');
    
    // Clear previous results
    questionsList.innerHTML = '';
    if (questionCount) {
        questionCount.textContent = count;
    }
    
    // Create question cards with checkboxes
    questions.forEach((question, index) => {
        const questionCard = document.createElement('div');
        questionCard.className = 'panel panel-default question-card';
        questionCard.style.marginBottom = '15px';
        questionCard.setAttribute('data-index', index);
        
        questionCard.innerHTML = `
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-1">
                        <input type="checkbox" class="question-selector" data-index="${index}" id="question_${index}">
                    </div>
                    <div class="col-md-11">
                        <h6 class="panel-title">
                            <label for="question_${index}" style="cursor: pointer; margin: 0;">
                                <strong>Câu hỏi ${index + 1}:</strong> ${question.question}
                            </label>
                        </h6>
                    </div>
                </div>
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
    
    // Initialize bulk selection functionality
    initializeBulkSelection();
    
    // Show the section and hide info message
    if (multipleSection) {
        multipleSection.style.display = 'block';
    }
    
    const infoMessage = document.getElementById('bulkInfoMessage');
    if (infoMessage) {
        infoMessage.style.display = 'none';
    }
    
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
    document.getElementById('Category').value = '';
    document.getElementById('Topic').innerHTML = '<option value="">Select Category first</option>';
    document.getElementById('aiTopic').value = '';
}

// Load topics when category is selected
function loadTopics() {
    const categoryId = document.getElementById('Category').value;
    const topicSelect = document.getElementById('Topic');
    
    if (!categoryId) {
        topicSelect.innerHTML = '<option value="">Select Category first</option>';
        updateAITopic();
        return;
    }
    
    // Show loading
    topicSelect.innerHTML = '<option value="">Loading topics...</option>';
    
    fetch('get_topics.php?categoryId=' + categoryId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                topicSelect.innerHTML = '<option value="">Select Topic</option>';
                data.topics.forEach(topic => {
                    topicSelect.innerHTML += `<option value="${topic.TopicID}">${topic.TopicName}</option>`;
                });
            } else {
                topicSelect.innerHTML = '<option value="">Error loading topics</option>';
            }
            updateAITopic();
        })
        .catch(error => {
            console.error('Error:', error);
            topicSelect.innerHTML = '<option value="">Error loading topics</option>';
            updateAITopic();
        });
}

// Update AI topic field when Category/Topic changes
function updateAITopic() {
    const categorySelect = document.getElementById('Category');
    const topicSelect = document.getElementById('Topic');
    const aiTopicInput = document.getElementById('aiTopic');
    
    const categoryText = categorySelect.options[categorySelect.selectedIndex]?.text || '';
    const topicText = topicSelect.options[topicSelect.selectedIndex]?.text || '';
    
    if (categoryText && topicText && topicText !== 'Select Topic' && topicText !== 'Loading topics...' && topicText !== 'Error loading topics') {
        aiTopicInput.value = `${categoryText} - ${topicText}`;
    } else if (categoryText && categoryText !== 'Select Category') {
        aiTopicInput.value = categoryText;
    } else {
        aiTopicInput.value = '';
    }
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

// Bulk Selection Functions
function initializeBulkSelection() {
    // Handle individual checkbox changes
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkButtonState);
    });
    
    // Handle select all
    const selectAllBtn = document.getElementById('selectAllQuestions');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', selectAllQuestions);
    }
    
    // Handle deselect all
    const deselectAllBtn = document.getElementById('deselectAllQuestions');
    if (deselectAllBtn) {
        deselectAllBtn.addEventListener('click', deselectAllQuestions);
    }
    
    // Handle bulk insert
    const bulkInsertBtn = document.getElementById('bulkInsertQuestions');
    if (bulkInsertBtn) {
        bulkInsertBtn.addEventListener('click', bulkInsertQuestions);
    }
    
    // Initial state update
    updateBulkButtonState();
}

function selectAllQuestions() {
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.checked = true;
        highlightSelectedCard(checkbox);
    });
    updateBulkButtonState();
    showSuccessMessage('Đã chọn tất cả câu hỏi!');
}

function deselectAllQuestions() {
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        checkbox.checked = false;
        unhighlightSelectedCard(checkbox);
    });
    updateBulkButtonState();
    showSuccessMessage('Đã bỏ chọn tất cả câu hỏi!');
}

function updateBulkButtonState() {
    const selectedCheckboxes = document.querySelectorAll('.question-selector:checked');
    const selectedCount = selectedCheckboxes.length;
    const bulkButton = document.getElementById('bulkInsertQuestions');
    const countSpan = document.getElementById('selectedCount');
    
    if (countSpan) {
        countSpan.textContent = selectedCount;
    }
    
    if (bulkButton) {
        if (selectedCount > 0) {
            bulkButton.disabled = false;
            bulkButton.className = 'btn btn-success btn-sm';
        } else {
            bulkButton.disabled = true;
            bulkButton.className = 'btn btn-default btn-sm';
        }
    }
    
    // Update card highlighting
    document.querySelectorAll('.question-selector').forEach(checkbox => {
        if (checkbox.checked) {
            highlightSelectedCard(checkbox);
        } else {
            unhighlightSelectedCard(checkbox);
        }
    });
}

function highlightSelectedCard(checkbox) {
    const card = checkbox.closest('.question-card');
    if (card) {
        card.style.backgroundColor = '#e8f5e8';
        card.style.borderColor = '#28a745';
        card.style.borderWidth = '2px';
    }
}

function unhighlightSelectedCard(checkbox) {
    const card = checkbox.closest('.question-card');
    if (card) {
        card.style.backgroundColor = '';
        card.style.borderColor = '';
        card.style.borderWidth = '';
    }
}

async function bulkInsertQuestions() {
    const selectedCheckboxes = document.querySelectorAll('.question-selector:checked');
    const selectedIndices = Array.from(selectedCheckboxes).map(cb => parseInt(cb.dataset.index));
    
    if (selectedIndices.length === 0) {
        alert('Vui lòng chọn ít nhất một câu hỏi để thêm!');
        return;
    }
    
    const topic = document.getElementById('Topic').value;
    if (!topic || topic.trim() === '') {
        alert('Vui lòng nhập chủ đề trước khi thêm câu hỏi!');
        return;
    }
    
    const confirmMessage = `Bạn có chắc chắn muốn thêm ${selectedIndices.length} câu hỏi với chủ đề "${topic}" không?\n\nThao tác này không thể hoàn tác!`;
    
    if (!confirm(confirmMessage)) {
        return;
    }
    
    // Show loading state
    const bulkButton = document.getElementById('bulkInsertQuestions');
    const originalText = bulkButton.innerHTML;
    bulkButton.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang thêm...';
    bulkButton.disabled = true;
    
    try {
        // Prepare questions data
        const questionsToInsert = selectedIndices.map(index => window.generatedQuestions[index]);
        
        // Get selected Category and Topic from form
        const categoryId = document.getElementById('Category').value;
        const topicId = document.getElementById('Topic').value;
        
        if (!categoryId || !topicId) {
            alert('Please select Category and Topic before inserting questions!');
            return;
        }
        
        console.log('Category ID:', categoryId);
        console.log('Topic ID:', topicId);
        console.log('Questions to insert:', questionsToInsert);
        
        // Send to simple bulk insert endpoint
        const response = await fetch('simple_bulk_insert.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                topic: topic,
                categoryId: parseInt(categoryId),
                topicId: parseInt(topicId),
                questions: questionsToInsert
            })
        });
        
        const responseText = await response.text();
        console.log('HTTP Status:', response.status);
        console.log('Raw response:', responseText);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${responseText}`);
        }
        
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (parseError) {
            console.error('Parse error:', parseError);
            throw new Error('Invalid JSON response: ' + responseText.substring(0, 200));
        }
        
        console.log('Parsed result:', result);
        
        if (result.success) {
            showSuccessMessage(`Đã thêm thành công ${result.inserted_count} câu hỏi!`);
            
            // Remove inserted questions from display
            selectedIndices.forEach(index => {
                const card = document.querySelector(`[data-index="${index}"]`);
                if (card) {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                    const checkbox = card.querySelector('.question-selector');
                    checkbox.checked = false;
                    checkbox.disabled = true;
                }
            });
            
            updateBulkButtonState();
            
            // Ask if user wants to go to question list
            setTimeout(() => {
                if (confirm('Câu hỏi đã được thêm thành công! Bạn có muốn xem danh sách câu hỏi không?')) {
                    window.location.href = 'index.php';
                }
            }, 1500);
            
        } else {
            throw new Error(result.error || 'Không thể thêm câu hỏi');
        }
        
    } catch (error) {
        console.error('Error bulk inserting questions:', error);
        alert(`Lỗi khi thêm câu hỏi: ${error.message}`);
    } finally {
        // Restore button state
        bulkButton.innerHTML = originalText;
        updateBulkButtonState();
    }
}
</script>