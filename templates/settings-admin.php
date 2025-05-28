<form id="custommail-settings" method="post">
    <label for="mail_subject">Betreff:</label><br/>
    <input type="text" name="mail_subject" id="mail_subject" value="<?php p($_['mail_subject']); ?>" /><br/>

    <label for="mail_body">Nachricht:</label><br/>
    <textarea name="mail_body" id="mail_body"><?php p($_['mail_body']); ?></textarea><br/>

    <button class="button primary">Speichern</button>
</form>
