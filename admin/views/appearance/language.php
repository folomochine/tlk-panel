<?php if( !route(3) ): ?>
<div>
  <div class="settings-header__table">
    <a href="<?php echo site_url("admin/appearance/language/new") ?>"  class="btn btn-default m-b">Ajouter une nouvelle langue</a>
  </div>
   <table class="table report-table" style="border:1px solid var(--border)">
      <thead>
         <tr>
            <th><div style="float:left;">Nom de la langue</div></th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php foreach($languageList as $language): ?>
         <tr class="<?php if( $language["language_type"] == 1 ): echo 'grey'; endif; ?>">
            <td><div style="float:left;"> <?php echo $language["language_name"]; if( $language["default_language"] == 1 ): echo ' <span class="badge">Par défaut</span>'; endif; ?> </div></td>
            <td class="text-right col-md-1">
              <div class="dropdown pull-right">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle btn-xs-caret" data-toggle="dropdown">Options <span class="caret"></span></button>
                <ul class="dropdown-menu">
                  <?php if( countRow(["table"=>"languages","where"=>["language_type"=>"2"]]) > 1 && $language["language_type"] == 2 ): ?>
                    <li>
                      <a href="<?php echo site_url('admin/appearance/language/?lang-id='.$language["language_code"].'&lang-type=1') ?>">
                        Désactiver
                      </a>
                    </li>
                  <?php endif; ?>
                  <?php if( $language["language_type"] == 1 ): ?>
                    <li>
                      <a href="<?php echo site_url('admin/appearance/language/?lang-id='.$language["language_code"].'&lang-type=2') ?>">
                        Activer
                      </a>
                    </li>
                  <?php endif; ?>
                  <li>
                    <a href="<?php echo site_url('admin/appearance/language/'.$language["language_code"]) ?>">
                    Modifier
                    </a>
                  </li>
                </ul>
              </div>
            </td>
         </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>
<?php elseif( route(3) == "new" ): ?>
   
<div>
   <div class="panel panel-default">
      <div class="panel-body">
        <?php if( $error ): ?>
          <div class="alert alert-danger "><?php echo $errorText; ?></div>
        <?php endif; ?>
         <form action="<?php echo site_url('admin/appearance/language/new') ?>" method="post" enctype="multipart/form-data">
           <div class="form-group">
              <label class="control-label">Nom de la langue</label>
              <input type="text" class="form-control" name="language">
           </div>
           <div class="form-group">
              <label class="control-label">Code de la langue</label>
              <select class="form-control" name="languagecode">
                 <option value="ar">ar (Arabe)</option>
                 <option value="af">af (Afrikaans)</option>
                 <option value="am">am (Amharique)</option>
                 <option value="sq">sq (Albanais)</option>
                 <option value="hy">hy (Arménien)</option>
                 <option value="az">az (Azerbaïdjanais)</option>
                 <option value="eu">eu (Basque)</option>
                 <option value="bn">bn (Bengali)</option>
                 <option value="bg">bg (Bulgare)</option>
                 <option value="ca">ca (Catalan)</option>
                 <option value="zh-HK">zh-HK (Chinois Hong Kong)</option>
                 <option value="zh-CN">zh-CN (Chinois Simplifié)</option>
                 <option value="zh-TW">zh-TW (Chinois Traditionnel)</option>
                 <option value="hr">hr (Croate)</option>
                 <option value="cs">cs (Tchèque)</option>
                 <option value="da">da (Danois)</option>
                 <option value="nl">nl (Néerlandais)</option>
                 <option value="en-GB">en-GB (Anglais UK)</option>
                 <option value="en">en (Anglais US)</option>
                 <option value="et">et (Estonien)</option>
                 <option value="fil">fil (Filipino)</option>
                 <option value="fi">fi (Finnois)</option>
                 <option value="fr">fr (Français)</option>
                 <option value="fr-CA">fr-CA (Français Canadien)</option>
                 <option value="gl">gl (Galicien)</option>
                 <option value="ka">ka (Géorgien)</option>
                 <option value="de">de (Allemand)</option>
                 <option value="de-AT">de-AT (Allemand Autriche)</option>
                 <option value="de-CH">de-CH (Allemand Suisse)</option>
                 <option value="el">el (Grec)</option>
                 <option value="gu">gu (Gujarati)</option>
                 <option value="iw">iw (Hébreu)</option>
                 <option value="hi">hi (Hindi)</option>
                 <option value="hu">hu (Hongrois)</option>
                 <option value="is">is (Islandais)</option>
                 <option value="id">id (Indonésien)</option>
                 <option value="it">it (Italien)</option>
                 <option value="ja">ja (Japonais)</option>
                 <option value="kn">kn (Kannada)</option>
                 <option value="ko">ko (Coréen)</option>
                 <option value="lo">lo (Lao)</option>
                 <option value="lv">lv (Letton)</option>
                 <option value="lt">lt (Lituanien)</option>
                 <option value="ms">ms (Malais)</option>
                 <option value="ml">ml (Malayalam)</option>
                 <option value="mr">mr (Marathi)</option>
                 <option value="mn">mn (Mongol)</option>
                 <option value="no">no (Norvégien)</option>
                 <option value="fa">fa (Persan)</option>
                 <option value="pl">pl (Polonais)</option>
                 <option value="pt">pt (Portugais)</option>
                 <option value="pt-BR">pt-BR (Portugais Brésil)</option>
                 <option value="pt-PT">pt-PT (Portugais Portugal)</option>
                 <option value="ro">ro (Roumain)</option>
                 <option value="ru">ru (Russe)</option>
                 <option value="sr">sr (Serbe)</option>
                 <option value="si">si (Cingalais)</option>
                 <option value="sk">sk (Slovaque)</option>
                 <option value="sl">sl (Slovène)</option>
                 <option value="es">es (Espagnol)</option>
                 <option value="es-419">es-419 (Espagnol Amérique Latine)</option>
                 <option value="sw">sw (Swahili)</option>
                 <option value="sv">sv (Suédois)</option>
                 <option value="ta">ta (Tamoul)</option>
                 <option value="te">te (Télougou)</option>
                 <option value="th">th (Thaï)</option>
                 <option value="tr">tr (Turc)</option>
                 <option value="uk">uk (Ukrainien)</option>
                 <option value="ur">ur (Ourdou)</option>
                 <option value="vi">vi (Vietnamien)</option>
                 <option value="zu">zu (Zoulou)</option>
              </select>
           </div>
           <hr>
            <?php foreach( $languageArray as $key => $val ): ?>
              <div class="form-group">
                 <label class="control-label"><?php echo $key; ?></label>
                 <input type="text" class="form-control" name="Language[<?php echo $key; ?>]" value="<?php echo $val;?>">
              </div>
            <?php endforeach; ?>
            <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
         </form>
      </div>
   </div>
</div>

<?php elseif( route(3) ): ?>
<div>
<form action="<?php echo site_url('admin/appearance/language/'.route(3)) ?>" method="post" enctype="multipart/form-data">
   <div class="panel panel-default">
   
      <div class="panel-body">
         
           <div class="form-group">
              <label class="control-label">Nom de la langue</label>
              <input type="text" class="form-control" name="language" value="<?php echo $language["language_name"] ?>">
           </div>
           <div class="form-group">
              <label class="control-label">Code de la langue</label>
              <select class="form-control" name="languagecode">
                 <option value="ar" <?php if( $language["language_code"] == "ar" ): echo 'selected'; endif; ?>>ar (Arabe)</option>
                 <option value="af" <?php if( $language["language_code"] == "af" ): echo 'selected'; endif; ?>>af (Afrikaans)</option>
                 <option value="am" <?php if( $language["language_code"] == "am" ): echo 'selected'; endif; ?>>am (Amharique)</option>
                 <option value="sq" <?php if( $language["language_code"] == "sq" ): echo 'selected'; endif; ?>>sq (Albanais)</option>
                 <option value="hy" <?php if( $language["language_code"] == "hy" ): echo 'selected'; endif; ?>>hy (Arménien)</option>
                 <option value="az" <?php if( $language["language_code"] == "az" ): echo 'selected'; endif; ?>>az (Azerbaïdjanais)</option>
                 <option value="eu" <?php if( $language["language_code"] == "eu" ): echo 'selected'; endif; ?>>eu (Basque)</option>
                 <option value="bn" <?php if( $language["language_code"] == "bn" ): echo 'selected'; endif; ?>>bn (Bengali)</option>
                 <option value="bg" <?php if( $language["language_code"] == "bg" ): echo 'selected'; endif; ?>>bg (Bulgare)</option>
                 <option value="ca" <?php if( $language["language_code"] == "ca" ): echo 'selected'; endif; ?>>ca (Catalan)</option>
                 <option value="zh-HK" <?php if( $language["language_code"] == "zh-HK" ): echo 'selected'; endif; ?>>zh-HK (Chinois Hong Kong)</option>
                 <option value="zh-CN" <?php if( $language["language_code"] == "zh-CN" ): echo 'selected'; endif; ?>>zh-CN (Chinois Simplifié)</option>
                 <option value="zh-TW" <?php if( $language["language_code"] == "zh-TW" ): echo 'selected'; endif; ?>>zh-TW (Chinois Traditionnel)</option>
                 <option value="hr" <?php if( $language["language_code"] == "hr" ): echo 'selected'; endif; ?>>hr (Croate)</option>
                 <option value="cs" <?php if( $language["language_code"] == "cs" ): echo 'selected'; endif; ?>>cs (Tchèque)</option>
                 <option value="da" <?php if( $language["language_code"] == "da" ): echo 'selected'; endif; ?>>da (Danois)</option>
                 <option value="nl" <?php if( $language["language_code"] == "nl" ): echo 'selected'; endif; ?>>nl (Néerlandais)</option>
                 <option value="en-GB" <?php if( $language["language_code"] == "en-GB" ): echo 'selected'; endif; ?>>en-GB (Anglais UK)</option>
                 <option value="en" <?php if( $language["language_code"] == "en" ): echo 'selected'; endif; ?>>en (Anglais US)</option>
                 <option value="et" <?php if( $language["language_code"] == "et" ): echo 'selected'; endif; ?>>et (Estonien)</option>
                 <option value="fil" <?php if( $language["language_code"] == "fil" ): echo 'selected'; endif; ?>>fil (Filipino)</option>
                 <option value="fi" <?php if( $language["language_code"] == "fi" ): echo 'selected'; endif; ?>>fi (Finnois)</option>
                 <option value="fr" <?php if( $language["language_code"] == "fr" ): echo 'selected'; endif; ?>>fr (Français)</option>
                 <option value="fr-CA" <?php if( $language["language_code"] == "fr-CA" ): echo 'selected'; endif; ?>>fr-CA (Français Canadien)</option>
                 <option value="gl" <?php if( $language["language_code"] == "gl" ): echo 'selected'; endif; ?>>gl (Galicien)</option>
                 <option value="ka" <?php if( $language["language_code"] == "ka" ): echo 'selected'; endif; ?>>ka (Géorgien)</option>
                 <option value="de" <?php if( $language["language_code"] == "de" ): echo 'selected'; endif; ?>>de (Allemand)</option>
                 <option value="de-AT" <?php if( $language["language_code"] == "de-AT" ): echo 'selected'; endif; ?>>de-AT (Allemand Autriche)</option>
                 <option value="de-CH" <?php if( $language["language_code"] == "de-CH" ): echo 'selected'; endif; ?>>de-CH (Allemand Suisse)</option>
                 <option value="el" <?php if( $language["language_code"] == "el" ): echo 'selected'; endif; ?>>el (Grec)</option>
                 <option value="gu" <?php if( $language["language_code"] == "gu" ): echo 'selected'; endif; ?>>gu (Gujarati)</option>
                 <option value="iw" <?php if( $language["language_code"] == "iw" ): echo 'selected'; endif; ?>>iw (Hébreu)</option>
                 <option value="hi" <?php if( $language["language_code"] == "hi" ): echo 'selected'; endif; ?>>hi (Hindi)</option>
                 <option value="hu" <?php if( $language["language_code"] == "hu" ): echo 'selected'; endif; ?>>hu (Hongrois)</option>
                 <option value="is" <?php if( $language["language_code"] == "is" ): echo 'selected'; endif; ?>>is (Islandais)</option>
                 <option value="id" <?php if( $language["language_code"] == "id" ): echo 'selected'; endif; ?>>id (Indonésien)</option>
                 <option value="it" <?php if( $language["language_code"] == "it" ): echo 'selected'; endif; ?>>it (Italien)</option>
                 <option value="ja" <?php if( $language["language_code"] == "ja" ): echo 'selected'; endif; ?>>ja (Japonais)</option>
                 <option value="kn" <?php if( $language["language_code"] == "kn" ): echo 'selected'; endif; ?>>kn (Kannada)</option>
                 <option value="ko" <?php if( $language["language_code"] == "ko" ): echo 'selected'; endif; ?>>ko (Coréen)</option>
                 <option value="lo" <?php if( $language["language_code"] == "lo" ): echo 'selected'; endif; ?>>lo (Lao)</option>
                 <option value="lv" <?php if( $language["language_code"] == "lv" ): echo 'selected'; endif; ?>>lv (Letton)</option>
                 <option value="lt" <?php if( $language["language_code"] == "lt" ): echo 'selected'; endif; ?>>lt (Lituanien)</option>
                 <option value="ms" <?php if( $language["language_code"] == "ms" ): echo 'selected'; endif; ?>>ms (Malais)</option>
                 <option value="ml" <?php if( $language["language_code"] == "ml" ): echo 'selected'; endif; ?>>ml (Malayalam)</option>
                 <option value="mr" <?php if( $language["language_code"] == "mr" ): echo 'selected'; endif; ?>>mr (Marathi)</option>
                 <option value="mn" <?php if( $language["language_code"] == "mn" ): echo 'selected'; endif; ?>>mn (Mongol)</option>
                 <option value="no" <?php if( $language["language_code"] == "no" ): echo 'selected'; endif; ?>>no (Norvégien)</option>
                 <option value="fa" <?php if( $language["language_code"] == "fa" ): echo 'selected'; endif; ?>>fa (Persan)</option>
                 <option value="pl" <?php if( $language["language_code"] == "pl" ): echo 'selected'; endif; ?>>pl (Polonais)</option>
                 <option value="pt" <?php if( $language["language_code"] == "pt" ): echo 'selected'; endif; ?>>pt (Portugais)</option>
                 <option value="pt-BR" <?php if( $language["language_code"] == "pt-BR" ): echo 'selected'; endif; ?>>pt-BR (Portugais Brésil)</option>
                 <option value="pt-PT" <?php if( $language["language_code"] == "pt-PT" ): echo 'selected'; endif; ?>>pt-PT (Portugais Portugal)</option>
                 <option value="ro" <?php if( $language["language_code"] == "ro" ): echo 'selected'; endif; ?>>ro (Roumain)</option>
                 <option value="ru" <?php if( $language["language_code"] == "ru" ): echo 'selected'; endif; ?>>ru (Russe)</option>
                 <option value="sr" <?php if( $language["language_code"] == "sr" ): echo 'selected'; endif; ?>>sr (Serbe)</option>
                 <option value="si" <?php if( $language["language_code"] == "si" ): echo 'selected'; endif; ?>>si (Cingalais)</option>
                 <option value="sk" <?php if( $language["language_code"] == "sk" ): echo 'selected'; endif; ?>>sk (Slovaque)</option>
                 <option value="sl" <?php if( $language["language_code"] == "sl" ): echo 'selected'; endif; ?>>sl (Slovène)</option>
                 <option value="es" <?php if( $language["language_code"] == "es" ): echo 'selected'; endif; ?>>es (Espagnol)</option>
                 <option value="es-419" <?php if( $language["language_code"] == "es-419" ): echo 'selected'; endif; ?>>es-419 (Espagnol Amérique Latine)</option>
                 <option value="sw" <?php if( $language["language_code"] == "sw" ): echo 'selected'; endif; ?>>sw (Swahili)</option>
                 <option value="sv" <?php if( $language["language_code"] == "sv" ): echo 'selected'; endif; ?>>sv (Suédois)</option>
                 <option value="ta" <?php if( $language["language_code"] == "ta" ): echo 'selected'; endif; ?>>ta (Tamoul)</option>
                 <option value="te" <?php if( $language["language_code"] == "te" ): echo 'selected'; endif; ?>>te (Télougou)</option>
                 <option value="th" <?php if( $language["language_code"] == "th" ): echo 'selected'; endif; ?>>th (Thaï)</option>
                 <option value="tr" <?php if( $language["language_code"] == "tr" ): echo 'selected'; endif; ?>>tr (Turc)</option>
                 <option value="uk" <?php if( $language["language_code"] == "uk" ): echo 'selected'; endif; ?>>uk (Ukrainien)</option>
                 <option value="ur" <?php if( $language["language_code"] == "ur" ): echo 'selected'; endif; ?>>ur (Ourdou)</option>
                 <option value="vi" <?php if( $language["language_code"] == "vi" ): echo 'selected'; endif; ?>>vi (Vietnamien)</option>
                 <option value="zu" <?php if( $language["language_code"] == "zu" ): echo 'selected'; endif; ?>>zu (Zoulou)</option>
              </select>
           </div>
           <hr>
            <?php foreach( $languageArray as $key => $val ): ?>
              <div class="form-group">
                 <label class="control-label"><?php echo $key; ?></label>
                 <input type="text" class="form-control" name="Language[<?php echo $key; ?>]" value="<?php echo $val;?>">
              </div>
            <?php endforeach; ?>
            
      </div>
   </div>
   <button type="submit" class="btn btn-primary">Mettre à jour</button>
         </form>
</div>
<?php endif; ?>
