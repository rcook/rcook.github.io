<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Setting up passwordless PuTTY access to server</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
  <script>
  $(function () {
    var updateUserName = function () {
      var userName = $("#user-name").val();
      $(".user-name").text(userName);
    };
    var updateHostFqdn = function () {
      var hostFqdn = $("#host-fqdn").val();
      $(".host-fqdn").text(hostFqdn);
    };
    var updateHostName = function () {
      var hostName = $("#host-name").val();
      $(".host-name").text(hostName);
    };
    var updatePuttyInstallationDirectory = function () {
      var puttyInstallationDirectory = $("#putty-installation-directory").val();
      $(".putty-installation-directory").text(puttyInstallationDirectory);
    };
    var updateFileZillaInstallationDirectory = function () {
      var fileZillaInstallationDirectory = $("#filezilla-installation-directory").val();
      $(".filezilla-installation-directory").text(fileZillaInstallationDirectory);
    };
    var buildContents = function () {
      var currentSection = undefined;
      var sections = [];
      $("h1, h2").each(function () {
        var $element = $(this);
        var nodeName = this.nodeName.toLowerCase();

        if ($element.attr("data-contents-role") != "skip") {
          if (nodeName == "h1") {
            currentSection = {text: $element.text(), subsections: []};
            sections.push(currentSection);
            $element
              .prepend("<a name=\"section" + sections.length + "\"></a><span class=\"section-index\">" + sections.length + ".</span> ")
              .append(" <a class=\"contents-link\" href=\"#contents\">Contents</a>");
          }
          else if (nodeName == "h2") {
            if (typeof currentSection != "undefined") {
              var subsection = {text: $element.text()};
              currentSection.subsections.push(subsection);
              $element
                .prepend("<a name=\"section" + sections.length + "-" + currentSection.subsections.length + "\"></a><span class=\"section-index\">" + sections.length + "." + currentSection.subsections.length + "</span> ")
                .append(" <a class=\"contents-link\" href=\"#contents\">Contents</a>");
            }
          }
        }
      });

      if (sections.length > 0) {
        var html = "<ol>";
        for (var i = 0; i < sections.length; ++i) {
          var section = sections[i];
          html += "<li><a href=\"#section" + (i + 1) + "\">" + section.text + "</a></li>";
          if (section.subsections.length > 0) {
            html += "<ol>";
            for (var j = 0; j < section.subsections.length; ++j) {
              var subsection = section.subsections[j];
              html += "<li><a href=\"#section" + (i + 1) + "-" + (j + 1) + "\">" + subsection.text + "</a></li>";
            }
            html += "</ol>";
          }
        }
        html += "</ol>";
        $("#contents").html("<ol>" + html + "</ol>");
      }
    };

    $("#user-name").keyup(updateUserName);
    $("#host-fqdn").keyup(updateHostFqdn);
    $("#host-name").keyup(updateHostName);
    $("#putty-installation-directory").keyup(updatePuttyInstallationDirectory);
    $("#filezilla-installation-directory").keyup(updateFileZillaInstallationDirectory);

    updateUserName();
    updateHostFqdn();
    updatePuttyInstallationDirectory();
    updateFileZillaInstallationDirectory();
    buildContents();
  });
  </script>
  <style>
  body {
    font-family: Segoe UI, Trebuchet, Arial, Sans-Serif;
    width: 75%;
    margin: auto;
  }
  h1, h2, h3 {
    font-family: Segoe UI Light, Trebuchet, Arial, Sans-Serif;
  }
  #banner {
    font-size: 2.5em;
    font-family: Segoe UI Light, Trebuchet, Arial, Sans-Serif;
    font-weight: bold;
  }
  #parameters {
    float: right;
    background-color: Silver;
    font-size: 0.75em;
  }
  #parameters input {
    font-size: 0.9em;
    min-width: 20em;
  }
  .section-index {
    font-size: smaller;
    font-style: italic;
  }
  .contents-link {
    font-size: small;
  }
  .file-path {
    font-family: Monospace;
    font-weight: bold;
    color: Purple;
  }
  .user-input {
    font-family: Monospace;
    font-weight: bold;
    color: Green;
  }
  .command {
    font-family: Monospace;
    font-weight: bold;
    color: Blue;
  }
  </style>
</head>
<body>
<div id="banner">
Setting up passwordless PuTTY access to server
</div>
<table id="parameters">
  <tr>
    <td><label for="user-name">User name</label></td>
    <td><input id="user-name" name="user-name" type="text" value="jcook"></td>
  </tr>
  <tr>
    <td><label for="host-fqdn">Fully-qualified domain name of host</label></td>
    <td><input id="host-fqdn" name="host-fqdn" type="text" value="monocuit.co.uk"></td>
  </tr>
  <tr>
    <td><label for="host-name">Host name</label></td>
    <td><input id="host-name" name="host-name" type="text" value="aleph"></td>
  </tr>
  <tr>
    <td><label for="putty-installation-directory">PuTTY installation directory</label></td>
    <td><input id="putty-installation-directory" name="putty-installation-directory" type="text" value="%USERPROFILE%\PuTTY"></td>
  </tr>
  <tr>
    <td><label for="filezilla-installation-directory">FileZilla installation directory</label></td>
    <td><input id="filezilla-installation-directory" name="filezilla-installation-directory" type="text" value="%USERPROFILE%\FileZilla-3.5.3"></td>
  </tr>
</table>
<a name="contents"></a>
<h1 data-contents-role="skip">Contents</h1>
<div id="contents"></div>
<h1>Initial setup</h1>
<p>
  You will only need to perform the setup steps in this section once on
  your Windows client machine. Some of these steps are moderately
  involved, so please do follow the instructions as closely as
  possible.
</p>
<h2>Install PuTTY binaries</h2>
<ol>
  <li><a href="http://the.earth.li/~sgtatham/putty/latest/x86/putty.zip">Download PuTTY</a>
  from the official web site.</li>
  <li>Unblock the downloaded <span class="file-path">putty.zip</span> file:
    <ol>
      <li>Locate the file in Windows Explorer in your <span class="file-path">Downloads</span> folder.</li>
      <li>Right-click on the file.</li>
      <li>Click <em>Properties</em>.</li>
      <li>Click <em>Unblock</em>.</li>
    </ol>
  </li>
  <li>Create a new folder for the downloaded PuTTY binaries, e.g. <span class="file-path"><span class="putty-installation-directory">putty-installation-directory</span></span>.</li>
  <li>Extract the contents of <span class="file-path">putty.zip</span> into this folder.</li>
</ol>
<h2>Generate public-private key pair</h2>
<ol>
  <li>In Windows Explorer, double-click on <span class="file-path">PUTTYGEN.EXE</span> in the
  <span class="file-path"><span class="putty-installation-directory">putty-installation-directory</span></span> folder to launch <em>PuTTY Key Generator</em>.</li>
  <li>In the <em>Parameters</em> section of the main window:
    <ol>
      <li>Set <em>Type of key to generate</em> to <span class="user-input">SSH-2 RSA</span>.</li>
      <li>Set <em>Number of bits in a generated key</em> to <span class="user-input">2048</span>.</li>
    </ol>
  </li>
  <li>In the <em>Actions</em> section, click <em>Generate</em>.</li>
  <li>Wiggle your mouse over the window as per the instructions. This generates lots of
  nice cryptographically secure random numbers.</li>
  <li>Set <em>Key passphrase</em> and <em>Confirm passphrase</em> to a strong passphrase:
  this is used to protect the private key on your local machine and is never transmitted
  to the server: the private key file is locally encrypted with this passphrase so that if
  your computer is compromised, the private key can only be used by someone with knowledge
  of the passphrase.</li>
  <li>Click <em>Save private key</em>, navigate to the folder
  <span class="file-path"><span class="putty-installation-directory">putty-installation-directory</span></span> and save your private key with the
  file name <span class="file-path"><span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span>.ppk</span> (the name is entirely up to you
  but the remaining instructions refer to this file name and you'll need to replace occurrences
  of this name with the name you choose here).</li>
  <li>Press <em>Alt+P</em> and <em>Ctrl+C</em> to copy the public key in OpenSSH format,
  paste this string (using <em>Ctrl+V</em>) into an e-mail and send this e-mail to me.</li>
  <li>Close this program and wait for me to install the public key on my server. When this
  has been done you can proceed to the next step.</li>
</ol>
<h2>Create a shortcut to unlock your private key when you log into Windows</h2>
<ol>
  <li>Right-click on the Windows desktop and select <em>New</em> and <em>Shortcut</em>.</li>
  <li>Enter <span class="user-input"><span class="putty-installation-directory">putty-installation-directory</span>\PAGEANT.EXE <span class="putty-installation-directory">putty-installation-directory</span>\<span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span>.ppk</span>
  in the text box under <em>Type the location of the item:</em>.</li>
  <li>Click <em>Next</em>.</li>
  <li>In the text box under <em>Type a name for this shortcut:</em> enter a name such as
  <span class="user-input">Unlock <span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span></span> (the name is entirely up to you).</li>
  <li>Click <em>Finish</em>.</li>
  <li>Drag the newly created shortcut icon onto the <em>Start</em> menu and drop it inside your <em>Startup</em> folder.</li>
</ol>
<p>
  Now, whenever you log into Windows you'll be presented with the following prompt:
</p>
<img src="enter-passphrase.png" width="216" height="126">
<p>
  You should enter the passphrase you chose when you created the private key earlier on.
  This unlocks the local private key file and decrypts it into memory so that you can use
  the private key to connect to the server later on in the current Windows log-in session.
</p>
<h2>Create a shortcut to connect to server with PuTTY</h2>
<ol>
  <li>Right-click on the Windows desktop and select <em>New</em> and <em>Shortcut</em>.</li>
  <li>Enter <span class="user-input"><span class="putty-installation-directory">putty-installation-directory</span>\PUTTY.EXE <span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span> -i <span class="putty-installation-directory">putty-installation-directory</span>\<span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span>.ppk</span>
  in the text box under <em>Type the location of the item:</em>.</li>
  <li>Click <em>Next</em>.</li>
  <li>In the text box under <em>Type a name for this shortcut:</em> enter a name such as
  <span class="user-input"><span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span></span> (the name is entirely up to you).</li>
  <li>Click <em>Finish</em>.</li>
  <li>Move this shortcut to the location of your choice.</li>
</ol>
<h2>Install FileZilla</h2>
<ol>
  <li><a href="http://sourceforge.net/projects/filezilla/files/FileZilla_Client/3.5.3/FileZilla_3.5.3_win32.zip/download">Download</a> FileZilla 3.5.3</li>
  <li>Unblock the downloaded <span class="file-path">FileZilla_3.5.3_win32.zip</span> file:
    <ol>
      <li>Locate the file in Windows Explorer in your <span class="file-path">Downloads</span> folder.</li>
      <li>Right-click on the file.</li>
      <li>Click <em>Properties</em>.</li>
      <li>Click <em>Unblock</em>.</li>
    </ol>
  </li>
  <li>Create folder <span class="file-path"><span class="filezilla-installation-directory">filezilla-installation-directory</span></span>.</li>
  <li>Unzip contents of <span class="file-path">FileZilla_3.5.3_win32.zip</span> into <span class="file-path"><span class="filezilla-installation-directory">filezilla-installation-directory</span></span>.</li>
  <li>Open <span class="file-path"><span class="filezilla-installation-directory">filezilla-installation-directory</span></span> in Windows Explorer
  and create a shortcut to <span class="file-path">filezilla.exe</span> with name <span class="user-input">FileZilla</span>
  in a location of your choice.</li>
</ol>
<h2>Configure a FileZilla site for your account</h2>
<ol>
  <li>Launch FileZilla using shortcut.</li>
  <li>Press <em>Ctrl+S</em> to open Site Manager.</li>
  <li>Click <em>New Site</em>.</li>
  <li>Enter a name for your site, e.g. <span class="user-input"><span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span></span>.</li>
  <li>Set following values (leave others empty):
    <ul>
      <li><em>Host</em>: <span class="user-input"><span class="host-fqdn">host-fqdn</span></span></li>
      <li><em>Protocol</em>: <span class="user-input">SFTP - SSH File Transfer Protocol</span></li>
      <li><em>Logon Type</em>: <span class="user-input">Normal</span></li>
      <li><em>User</em>: <span class="user-input"><span class="user-name">user-name</span></span></li>
      <li><em>Password</em>: empty&mdash;FileZilla will use the Pageant authentication agent</li>
    </ul>
  </li>
  <li>Click <em>OK</em>.</li>
</ol>
<h1>Logging into server</h1>
<p>
  You'll need to do this each time you want to connect to the server:
</p>
<ul>
  <li>Double-click the <em><span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span></em> shortcut created previously.</li>
</ul>
<p>
  Note that the very first time you attempt to connect to the server from your machine
  you'll get the following security alert:
<p>
<img src="security-alert.png" width="435" height="294">
<p>
  This is expected. Please verify that the displayed fingerprint is exactly as given in
  the example above&mdash;this identifies my server to your machine. Click <em>Yes</em>
  to permanently add this machine to PuTTY's cache. You'll never be prompted with this
  message again on this machine. If you ever see a window pop up like this, this indicates
  that the server's signature has changed. You should check with me to see if something
  odd has happened to the server.
</p>
<p>
  Once you have successfully logged in, you'll see a shell window looking something like the following:
</p>
<img src="shell.png" width="675" height="424">
<p>
  <em><span class="host-name">host-name</span></em> is the host name of my server. As you can see, this server is running Ubuntu 11.04.
  The default shell is bash, so all the usual Linux commands will work. If you type <tt>ls</tt>,
  you'll see you have a <em>www</em> folder. This contains your web site.
</p>
<h2>Create a shortcut to start an SFTP session with PSFTP</h2>
<ol>
  <li>Right-click on the Windows desktop and select <em>New</em> and <em>Shortcut</em>.</li>
  <li>Enter <span class="user-input"><span class="putty-installation-directory">putty-installation-directory</span>\PSFTP.EXE <span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span> -i <span class="putty-installation-directory">putty-installation-directory</span>\<span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span>.ppk</span></span>
  in the text box under <em>Type the location of the item:</em>.</li>
  <li>Click <em>Next</em>.</li>
  <li>In the text box under <em>Type a name for this shortcut:</em> enter a name such as
  <span class="user-input">sftp <span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span></span> (the name is entirely up to you).</li>
  <li>Click <em>Finish</em>.</li>
  <li>Right-click the shortcut and select <em>Properties</em>.</li>
  <li>Enter the initial local directory for SFTP transfers in <em>Start in:</em>.</li>
  <li>Move this shortcut to the location of your choice.</li>
</ol>
<p>
  This shortcut will start a secure SFTP session over SSH to the server assuming that you have the Pageant
  authentication agent running already. You can use commands such as <span class="command">lpwd</span> and
  <span class="command">lcd</span> to view/change the local directory and the usual FTP-style commands to
  transfer files to/from the server.
</p>
<h2>Transferring files with FileZilla</h2>
<ol>
  <li>Launch FileZilla with your shortcut.</li>
  <li>In tool bar, click down arrow next to the <em>Open the Site Manager</em> button.</li>
  <li>Select the site (e.g. <span class="user-input"><span class="user-name">user-name</span>@<span class="host-fqdn">host-fqdn</span></span>) created before.</li>
  <li>Transfer files!</li>
</ol>
<h1>Appendix</h1>
<p>
  A few words of explanation about why I asked you to create two shortcuts is in order:
</p>
<ul>
  <li>Pageant is the SSH authentication agent: it takes your .ppk file (which is an encrypted
  version of your private key) and decrypts it into memory after you supply the correct passphrase
  (this is when the "Startup" shortcut runs). This program continues to run in memory, so that
  you don't have to keep typing in your passphrase repeatedly for the lifetime of your Windows
  session. Whenever you log out (by logging out or by restarting or shutting down Windows), the
  decrypted private key is unloaded from memory and you must re-enter the passphrase the next
  time you log in. This provides a measure of local security for your private key while
  minimizing the number of times you are forced to enter your passphrase: if you regularly log
  out of your laptop and somebody steals your machine, then your private key is not compromised
  and the thief cannot log into your web server and start doing bad things to it. Since the
  passphrase is for local decryption of your encrypted private key file, you never need to
  share it with anybody (not even me), since I only need the public key (this is the "ssh-rsa"
  value I asked you to copy and paste from the key generator program) in order to securely
  identify you on my server. Passwordless authentication using public key cryptography is far
  more secure than password-based authentication which is why I have disabled the latter on my
  server. I am a bit of a security fanatic as you may have noticed (and it sounds like you might
  be too!). The Pageant command line I provided for you means "run Pageant and decrypt the
  specified private key file (james.<span class="host-fqdn">host-fqdn</span>.ppk) into memory based on the user
  (that's you!) supplying the correct passphrase".</li>
  <li>PuTTY is the SSH shell program itself: this establishes a secure connection from your client
  machine to the server and runs the default shell on the server. The command line I provided for
  you means "establish an SSH connection for the user <span class="user-name">user-name</span> on the host <span class="host-fqdn">host-fqdn</span> using the
  identity information in the private key file james.<span class="host-fqdn">host-fqdn</span>.ppk". If PuTTY detects that
  the Pageant agent is running with a decrypted version of james.<span class="host-fqdn">host-fqdn</span> in memory it will
  use that private key information to authenticate with the server and not require you to re-enter
  the passphrase. If Pageant is not running at this point, PuTTY will prompt you for the passphrase
  and decrypt the private key file itself.</li>
</ul>
<p>
  Given this explanation, you might now understand why the name of the private key file given in my
  instructions was <span class="user-name">user-name</span>.<span class="host-fqdn">host-fqdn</span>.ppk and not james.<span class="host-fqdn">host-fqdn</span>.ppk - this is the identity
  information for user <span class="user-name">user-name</span> on the host <span class="host-fqdn">host-fqdn</span> and is unrelated to the Google Apps account
  I created for you. Anyway, the file name does not matter to Pageant or PuTTY (or my server for
  that matter) as long as you are consistent.
</p>
</body>
</html>
