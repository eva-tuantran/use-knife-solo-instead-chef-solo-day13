お問い合わせの種類 <?php echo Model_Contact::inquiry_type_label($contact->inquiry_type); ?>

件名 <?php echo $contact->subject; ?>

メールアドレス <?php echo $contact->email; ?>

電話番号 <?php echo $contact->tel; ?>

内容 <?php echo $contact->contents; ?>
