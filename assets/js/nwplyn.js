
            var nwplyn = {

                form: function(){

                    var doc = new YAHOO.util.Element(document);
                    var frms = doc.getElementsByTagName('form');

                    if(frms.length > 0){

                        var input = new YAHOO.util.Element(document.getElementById('uid'));
                            input.on('focus', function(){

                                this.get('element').value = '';

                            });
                            input.on('blur', function(){

                                if(this.get('element').value == '')
                                {

                                    this.get('element').value = this.get('element').defaultValue;

                                }

                            });

                         var submit = new YAHOO.util.Element(document.getElementById('submit'));
                             submit.on('click', function(e){

                                YAHOO.util.Event.preventDefault(e);

                                if(input.get('element').value != input.get('element').defaultValue)
                                {

                                    var frm = document.getElementById('form');
                                        frm.submit();

                                }

                             });

                    }


                },

                bookmark: function(){



                },

                ol: function(){

                   this.li = function(el)
                   {

                        var inst = new YAHOO.util.Element(el);
                            inst.on('mouseover', function(){

                                this.setStyle('background', '#eee');

                            });
                            inst.on('mouseout', function(){

                                this.setStyle('background', '#fff');

                            });
                            inst.on('click', function(){

                               var H = YAHOO.util.Dom.getViewportHeight();
                               var W = YAHOO.util.Dom.getViewportWidth();

                               var url = this.getElementsByTagName('input')[0];

                               var params  = 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=650,height=250,';
                                   params += 'left = ' + ((W/2)-650/2) + ',top = ' + ((H/2)-250/2);

                               window.open('http://twitter.com/share' + url.value, 'pop', params);

                            });



                   }

                   var ol = new YAHOO.util.Element('tracks');
                   var lis = ol.getElementsByTagName('li');

                   for(var i = 0; i < lis.length; i++) new this.li(lis[i]);

               }

           };


