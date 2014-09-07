<div class="hero">
<h1>Single-use pastes.</h1>
<h3>Paste. Send. Once they're seen they're gone for good. </h3>
</div>
<div class="container">
<form id="paste" method="POST" action="<?=base_url('app/submit');?>">
    <p><strong>Paste Title (Optional):</strong> <input type="text" name="pastetitle" id="titlebox"></p>
    <p><strong>We use <a href="https://daringfireball.net/projects/markdown/basics" tabIndex="-1">Markdown</a></strong></p>
    <textarea id="pastebox" name="pastecontents"></textarea>    
    <br/>
    <button type="submit" class="btn btn-success">Submit Post</button>
</form>
</div>