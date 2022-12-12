<td id='descriptionContainer'>
    Description:
    <p id='videoDescription'>
        Not Assigned yet
    </p>
</td>
<td style='width: fit-content'>
    <video id='videoPlayer' class="right" controls preload='auto' >
        <source id='sourcePath' src='<?php echo $_GET["path"] ?>' currentFile='<?php echo $_GET["fileName"] ?>' type='video/mp4' />
    </video>
</td>