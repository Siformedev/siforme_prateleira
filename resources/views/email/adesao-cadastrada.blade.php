<body>

<div style="width:100%;" align="center">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" valign="top" style="background-color:#53636e;" bgcolor="#53636e;">

                <br>
                <br>
                <table width="583" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF" style="background-color:#FFFFFF;"><img src="https://agenciapni.com.br/img_emkt/images/header.jpg" width="583" height="118"></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#FFFFFF" style="background-color:#FFFFFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="35" align="left" valign="top">&nbsp;</td>
                                    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" valign="top">
                                                    <div style="color:#245da5; font-family:Times New Roman, Times, serif; font-size:48px;">Parabéns e Obrigado!</div>
                                                    <div style="font-family: Verdana, Geneva, sans-serif; color:#898989; font-size:12px;">Adesão concluida com sucesso</div></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top"><img src="https://agenciapni.com.br/img_emkt/images/adesao.concluido.jpg" width="512" height="296" vspace="10"></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;">
                                                    <p>
                                                        Sejam bem vindos a um dos melhores momentos da sua vida. Sua Formatura!<br>
                                                        Em parceria com as nossas Comissões de Formatura, buscamos o desejo que desperte nas pessoas, o sentimento de vitória e de conquista.<br>
                                                        Acreditamos que cada indivíduo possui uma caminhada, uma jornada única, assim como cada evento nosso é um momento único e perfeito.<br>
                                                        Para a "Pingo No I"qualidade não é um ato, e sim um Hábito.<br>
                                                        Agora é hora de celebrar essa conquista, esse sonho, essa vitória e nada melhor que seja em grande estilo.<br>
                                                        Experimente algo nunca vivido, uma visão genuína e a sensação de êxtase.<br>
                                                        Sinta e explore os seus instintos.<br>
                                                    </p>
                                                    <hr>

                                                    <div style="color:#3482ad; font-size:19px;">Abaixo segue dados de sua adesão:</div>

                                                    <table width="500" border="0">
                                                        <tbody>
                                                        <tr>
                                                            <td width="136">Nome Completo:</td>
                                                            <td colspan="3">{{ $nome }} {{ $sobrenome }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email:</td>
                                                            <td colspan="3">{{ $email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CPF:</td>
                                                            <td colspan="3">{{ $cpf }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RG:</td>
                                                            <td colspan="3">{{ $rg }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>D. Nascimento:</td>
                                                            <td colspan="3">{{ $date_nascimento }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>CEP:</td>
                                                            <td colspan="3">{{ $cep }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Endereço:</td>
                                                            <td colspan="3">{{ $logradouro }}, {{ $numero }} {{ $complemento }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Bairro:</td>
                                                            <td colspan="3">{{ $bairro }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cidade:</td>
                                                            <td colspan="3">{{ $cidade }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estado:</td>
                                                            <td colspan="3">{{ $estado }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Telefones:</td>
                                                            <td colspan="3">{{ $telefone_residencial }} {{ $telefone_celular }}</td>
                                                        </tr>
                                                        @if($nome_do_pai and !empty($nome_do_pai))
                                                        <tr>
                                                            <td>Dados do Pai:</td>
                                                            <td colspan="3">{{ $nome_do_pai }} {{ $telefone_celular_pai }} {{ $email_do_pai }}</td>
                                                        </tr>
                                                        @endif()
                                                        @if($nome_da_mae and !empty($nome_da_mae))
                                                        <tr>
                                                            <td>Dados da Mãe:</td>
                                                            <td colspan="3">{{ $nome_da_mae }} {{ $telefone_celular_mae }} {{ $email_da_mae }}</td>
                                                        </tr>
                                                        @endif()
                                                        <tr>
                                                            <td colspan="4"><hr></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4">
                                                                <p>
                                                                    Siga as instruções logo abaixo e caso tenha alguma dúvida ou problema no acesso, favor entre em contato conosco através do telefone (11) 4221-9054.<br>
                                                                    <br>
                                                                    1- Acesse através do link: <a href="{{env('APP_URL')}}/login">{{env('APP_URL')}}/login</a> ;<br>
                                                                    2- Na barra superior coloque seu email e senha (provisória), após clique em Entrar;<br>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                        <tr style="background: red; color: #ffffff;">
                                                            <td>Senha provisória:</td>
                                                            <td colspan="3">{{ $senha }}</td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                    <p><br>
                                                        <br>
                                                        <br>
                                                    </p>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="13%"><b><img src="https://agenciapni.com.br/img_emkt/images/facebook.gif" alt="" width="24" height="23"></b></td>
                                                            <td width="87%" style="font-size:11px; color:#525252; font-family:Arial, Helvetica, sans-serif;"><p><b>Data e hora: {{ date('d/m/Y H:i:s') }}<br>
                                                                        <br>
                                                                        AGÊNCIA PINGO NO I<br>
                                                                        (11) 4221-9054 (segunda a sexta: 09h00 às 18h00)Contato: atendimento@agenciapni.com.br</b></p></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td align="left" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#525252;">&nbsp;</td>
                                            </tr>
                                        </table></td>
                                    <td width="35" align="left" valign="top">&nbsp;</td>
                                </tr>
                            </table></td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#3d90bd" style="background-color:#3d90bd;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="35">&nbsp;</td>
                                    <td height="50" valign="middle" style="color:#FFFFFF; font-size:11px; font-family:Arial, Helvetica, sans-serif;"><b>Endereço:</b><br>
                                        <b>Rua Major Carlos Del Prete, 1295 - Cêramica - São Caetano do Sul</b></td>
                                    <td width="35">&nbsp;</td>
                                </tr>
                            </table></td>
                    </tr>
                </table>
                <br>
                <br></td>
        </tr>
    </table>

</div>


