<?php
//BOT EM PHP CRIADO POR LEONEL MIGUINS
//não esqueça de por o bot como administrador

//não esqueça de setar o webhook. detalhes no arquivo README.MD

echo "<h1>O Bot no telegram feito em PHP está rodando!<h1>";


$input = file_get_contents('php://input');
$update = json_decode($input);
//preparando variaveis

$message  = $update->message;
$chat_id = $message->chat->id;
$chat_name = $message->chat->title;
$text = $message->text;
$msg_id = $message->message_id;

$user_name = $message->from->first_name;
$user_id = $message->from->id;

$member_name = $message->reply_to_message->from->first_name;
$member_id = $message->reply_to_message->from->id;

//token do bot pego no botfather
$token = 'TOKEN_DO_SEU_BOT';


if($text == "/start"){
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=O bot está rodando!"); 
   
}

 if($text == "/rest"){
   //restringir membro de mandar menssagem
       $data = $msg_data + 60; //restrição de 60 segundos
       file_get_contents("https://api.telegram.org/bot$token/restrictChatMember?chat_id=$chat_id&user_id=$member_id&permissions{can_send_messages: false}&until_date=$data"); 
       file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=Restrição em $member_name de 60 segundos!");
         
}

//botões com links
if($text == "/inline"){
   $inline_button1 = array("text"=>"Google url","url"=>"http://google.com");
   $inline_button2 = array("text"=>"👉 Canal Telegram","url"=>"https://t.me/AnimesDubladosTv");
   $inline_keyboard = [[$inline_button1,$inline_button2]];
   $keyboard=array("inline_keyboard"=>$inline_keyboard);
   $replyMarkup = json_encode($keyboard); 
   
  $txt = "<b>Botões com links: </b>";
      file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$txt&parse_mode=HTML&reply_markup=".$replyMarkup);

   }



if($text == "/userid"){
   $txt = "Seu chat id: $chat_id";
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$txt"); 
}

//kicka membros que ximgam
if(preg_match("/idiota/i", $text) == true or preg_match("/burro/i", $text) == true){
   
   file_get_contents("https://api.telegram.org/bot$token/banChatMember?chat_id=$chat_id&user_id=$user_id"); 
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=O usuario $user_name foi banido por que violou as regras!");
   
}

//kicka membros que enviam links

if(preg_match("/http/i", $text) == true or preg_match("/www./i", $text) == true or preg_match("/youtube.com/i", $text) == true){
   
   file_get_contents("https://api.telegram.org/bot$token/banChatMember?chat_id=$chat_id&user_id=$user_id"); 
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=O usuario $user_name foi banido por que enviou links no grupo! - Id da menssagem: $msg_id");
   file_get_contents("https://api.telegram.org/bot$token/deleteMessage?chat_id=$chat_id&message_id=$msg_id");
   
}

//teclado
if($text == "/teclado"){
   $keyboard = array(array("[Opção 1]","[Opção 2]","[Opção 3]"));
   $resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
   $reply = json_encode($resp);
       file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=Você não possui um personagem&reply_markup=".$reply); 
   
}


if($text == "/username"){
   $txt2 = "Seu nome de usuario: $user_name";
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$txt2"); 
}

if($text == "/sendimg"){
   $file = "https://pm1.narvii.com/6509/1bbd104778bf2491cf1a03cf6fcf17b2b9251844_hq.jpg";
   file_get_contents("https://api.telegram.org/bot$token/sendPhoto?chat_id=$chat_id&photo=$file&caption=Legenda da imagem."); 
}

//informações do usuario como nome e id
if($text == "/info"){
   if($member_name == ""){
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=Responda a menssagem de quem você quer obter informaões com /info !");
       
   }else{
   $txt3 = "Nome do usuario selecionado: $member_name Id: $member_id";
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$txt3"); 
   }
}

//salva as informações do usuario em um arquivo JSON na raiz da pasta do bot podendo ser acessado posteriormente
if($text == "/save"){
   $txt3 = '{
    "user-id": "'.$user_id.'",
    "User-name": "'.$user_name.'",
    "Chat-name": "'.$chat_name.'"
}';
   salvarDados($txt3, $user_id);
   file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=Salvando dados do usuario em um arquivo JSON"); 
}


function salvarDados($texto, $id){
// Meu arquivo
$arquivo = "$id.json";

// Dados para escrever no arquivo
$dados = $texto;

// Cria o recurso (abrir o arquivo)
$handle = fopen( $arquivo, 'w' );

// Escreve
$ler = fwrite( $handle, $dados );

// Fecha o arquivo
fclose($handle);

}

?>
