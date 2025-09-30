<?php if(!isset($_SESSION['USERID'])){ redirect(web_root."admin/index.php"); } ?>
<form class="form-horizontal span6" action="controller.php?action=add" method="POST">
  <div class="row"><div class="col-lg-12"><h1 class="page-header">Add AI Content</h1></div></div>
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Title">Title:</label>
      <div class="col-md-10"><input class="form-control input-sm" id="Title" name="Title" type="text" placeholder="Title"></div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Topic">Topic:</label>
      <div class="col-md-10"><input class="form-control input-sm" id="Topic" name="Topic" type="text" placeholder="e.g. Big Data, Algebra"></div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Difficulty">Difficulty:</label>
      <div class="col-md-10">
        <select class="form-control input-sm" id="Difficulty" name="Difficulty">
          <option value="easy">Easy</option>
          <option value="medium" selected>Medium</option>
          <option value="hard">Hard</option>
        </select>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-11">
      <label class="col-md-2 control-label" for="Body">Content:</label>
      <div class="col-md-10"><textarea class="form-control" id="Body" name="Body" rows="12" placeholder="Generated content will appear here..."></textarea></div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-md-11">
      <div class="col-md-10 col-md-offset-2">
        <button type="button" class="btn btn-success" id="btnGenerate"><i class="fa fa-magic"></i> Generate with AI</button>
        <button class="btn btn-primary" name="save" type="submit"><i class="fa fa-save"></i> Save</button>
      </div>
    </div>
  </div>
</form>

<script>
document.getElementById('btnGenerate').addEventListener('click', async function() {
  const topic = document.getElementById('Topic').value.trim();
  const difficulty = document.getElementById('Difficulty').value;
  if (!topic) { alert('Please enter a topic'); return; }
  try {
    const resp = await fetch('../exercises/gemini_api_simple.php', { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({ topic: topic + ' - Write a short lesson (300-600 words) with headings and bullet points. Output plain text, not JSON.', difficulty }) });
    const text = await resp.text();
    let data; try { data = JSON.parse(text); } catch(e){ data = null; }
    document.getElementById('Body').value = data && data.success && data.data && data.data.question ? (data.data.question + '\n\n' + Object.entries(data.data.choices).map(([k,v])=>k+'. '+v).join('\n')) : text;
  } catch (e) { alert('AI error: '+e.message); }
});
</script>


