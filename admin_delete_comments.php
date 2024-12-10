<div class='comment'>
    <img class="profile" src="uploads/<?= $row['profile_path'] ?>" alt='User Profile'>
    <div>
        <strong><?= htmlspecialchars($row['firstname'] . ' ' . $row['lastname']) ?> :</strong>
        <p class="content"> <?= htmlspecialchars($row['comment']) ?></p>
        <p class="date">Posted on <?= htmlspecialchars($row['created_at']) ?> </p>
        <a
            href="delete_comment.php?blog=<?= $row['post_id'] ?>&id=<?= $row['comment_id'] ?>"><button>Delete</button></a>
    </div>
</div>