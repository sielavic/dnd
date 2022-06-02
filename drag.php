<script>
  var elem_id = <?= $card->macrotasknote->id;?>;
      var column_id_drop = <?= $board->macrotasknote->id;?>;


      // var columnId = targetId.replace(/[^0-9]/g, "");
      //  var  supernote  = '#note_list_item_'+columnId+'_note';


      const zoneCard = document.querySelector('#card_reaload_' + column_id_drop);

      const zoneWork = document.querySelector('.page-content-inner');
      const zonePreWork = document.querySelector('.empty');
      const element = document.querySelector('#card_element_' + elem_id);


      // console.log(zoneCard);


      if (zonePreWork != null && element != null && typeof zonePreWork !== "undefined" && element != 0){
            zonePreWork.ondragover = allowDropPreWork;//срабатывает когда переносимый элемент над зоной

            function allowDropPreWork(event) {
                  event.preventDefault();
                  $('.empty').addClass("active-drop-wrap-prework");
                  $('#card_element_' + elem_id).addClass("board_list_item");
                  $('noteinput_'+elem_id+'_note').attr("disabled","disabled");
                  boardfullScreen();
            }

      }


      if (zoneWork != null && element != null && typeof zoneWork !== "undefined" && element != 0){
            zoneWork.ondragover = allowDropWork;//срабатывает когда переносимый элемент над зоной
            function allowDropWork(event) {
                  event.preventDefault();
                  $('.page-content-inner').addClass("active-drop-wrap");
                  $('#card_element_' + elem_id).addClass("board_list_item");
            }
            zoneWork.ondrop = dropWork;

            function dropWork(event) {
                  if (typeof currentWorkID !== 'undefined') {
                        let itemIds = event.dataTransfer.getData('card_id_drop');
                        var ids = itemIds.replace(/[^0-9]/g, "");
                        let work_id = currentWorkID;
                        let note_id = ids;
                        if (work_id && note_id) {
                              let itemId = event.dataTransfer.getData('card_id_drop');
                              let long_text = $('.word-wrap-breakword, .well_text').text().replace(/Описание/g, '').replace(/\s{2,}/g, ' ');
                              if (long_text.length >= 50) {
                                    var short_text = long_text.substring(0, 50);
                                    var lastIndex = short_text.lastIndexOf(" ");       // позиция последнего пробела
                                    short_text = short_text.substring(0, lastIndex) + '...'; // обрезаем до последнего слова
                              }else{
                                    var short_text = long_text;
                              }
                              saveCardInWork(note_id, work_id );
                              saveSortCard();
                              widget_dashboard('updateDesc', itemId.replace(/[^0-9]/g, ""), 'card', short_text.replace(new RegExp("\\r?\\n", "g"), ""), false, false, null, long_text.replace(new RegExp("\\r?\\n", "g"), ""), work_id);//берем текст с задачи или согласования и отправляем в карточку
                              widget_dashboard('update', itemId.replace(/[^0-9]/g, ""), 'card', short_text.replace(new RegExp("\\r?\\n", "g"), ""), false, dropable = true, <?=  $board->macrotasknote->id ?>);

                              $('#title-work-card_'+note_id).show();
                              $('#noteinput_'+note_id +'_note').val(short_text);
                              $('#description_card_'+note_id).html('<span style="margin: 5px;" title="Эта карточка с дополнительным описанием" class="badge-icon icon-sm  fa fa-align-left "></span>');
                        }
                        $('.page-content-inner').removeClass("active-drop-wrap");
                        $('.empty').removeClass("active-drop-wrap-prework");
                        showDashboard();
                  }
                  saveSortCard();
            }
      }


      // console.log(elem_id);
      if (typeof zoneCard !== "undefined" && typeof element !== "undefined" && element != null && element != 0 && zoneCard != null &&  zoneCard !== '' && element !== '' ) {


            zoneCard.ondragover = allowDropCard;//срабатывает когда переносимый элемент над зоной

            function allowDropCard(event) {
                  console.log(column_id_drop);
                  event.preventDefault();
            }


            element.ondragstart = drag;
            function drag(event) {
                  event.target.classList.add(`selected`);
                  var text = '';
                  text = '<?=$card->macrotasknote->text;?>'
                  event.dataTransfer.setData('card_id_drop', event.target.id);//айди перемещаемого объекта в ивент
                  event.dataTransfer.setData('card_text', text.replace(new RegExp("\\r?\\n", "g"), ""));
            }


            zoneCard.ondrop = dropCard;
            function dropCard(event) {
                   event.target.classList.remove(`selected`);
                  let itemId = event.dataTransfer.getData('card_id_drop');
                  let card_text = event.dataTransfer.getData('card_text');
                  this.append(document.getElementById(itemId));
                  widget_dashboard('updateParent', itemId.replace(/[^0-9]/g, ""), 'card', card_text, false, dropable = true, <?= $board->macrotasknote->id;?>);
                  saveSortCard();
            }
      }


      function allowDropNewCard(event) {
            // console.log(column_id_drop);
            event.preventDefault();
      }



      function dragNew(event) {
            event.target.classList.add(`selected`);
            var text = '';
            text = '<?=$card->macrotasknote->text;?>';
            var targetId = event.dataTransfer.getData('card_id_drop');
             var cardId = targetId.replace(/[^0-9]/g, "");

            event.dataTransfer.setData('card_id_drop', targetId);//айди перемещаемого объекта в ивент
            event.dataTransfer.setData('card_text', text.replace(new RegExp("\\r?\\n", "g"), ""));
      }



      function dropNewCard(event) {
            event.target.classList.remove(`selected`);
            let itemId = event.dataTransfer.getData('card_id_drop');
            let card_text = event.dataTransfer.getData('card_text');
            var targetId = $('.card_reload').last().attr('id');
            var columnId = targetId.replace(/[^0-9]/g, "");
            $('#card_reaload_' +  columnId).append(document.getElementById(itemId));
            widget_dashboard('updateParent', itemId.replace(/[^0-9]/g, ""), 'card', card_text, false, dropable = true, columnId);
            saveSortCard();
      }
      
      </script>
