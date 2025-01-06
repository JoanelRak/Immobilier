<main>
    <section class="content-section">
        <?php
        // Access cadeaux from the passed data, fall back to session if needed
        $cadeaux = $cadeaux ?? $_SESSION['cadeaux'] ?? [];

        $categories = [
            ['id' => 2, 'name' => 'Men Cadeaux', 'gifts' => $cadeaux['men'] ?? []],
            ['id' => 1, 'name' => 'Women Cadeaux', 'gifts' => $cadeaux['women'] ?? []],
            ['id' => 3, 'name' => 'Neutre Cadeaux', 'gifts' => $cadeaux['neutre'] ?? []]
        ];

        foreach ($categories as $category) {
            if (!empty($category['gifts'])) { ?>
                <h1 class="category"><?php echo $category['name'] ?>:</h1>
                <div class="gift-container" data-category="<?php echo $category['id'] ?>">
                    <?php foreach ($category['gifts'] as $cadeau) { ?>
                        <div class="card"
                             data-id="<?php echo $cadeau['id'] ?>"
                             data-category="<?php echo $category['id'] ?>">
                            <img src="/assets/<?php echo $cadeau['image'] ?>"
                                 class="image_cadeau"
                                 alt="<?php echo $cadeau['description_cadeau'] ?>">
                            <h2 class="gift-description"><?php echo $cadeau['description_cadeau'] ?></h2>
                            <p class="gift-price">Price: <?php echo $cadeau['prix'] ?></p>
                            <p class="gift-stars">Stars: <?php echo $cadeau['etoile'] ?></p>
                        </div>
                    <?php } ?>
                </div>
            <?php }
        } ?>
    </section>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectedGifts = new Set();

        // Handle card clicks
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', async function () {
                const category = this.dataset.category;
                try {
                    const response = await fetch(`/api/random-gift/${category}`);
                    const data = await response.json();

                    if (data.success) {
                        updateCard(this, data.gift);
                    } else {
                        console.error('Error fetching new gift');
                    }
                } catch (error) {
                    console.error('Error:', error);
                }
            });

            // Handle gift selection
            card.addEventListener('click', function (e) {
                if (e.shiftKey) {  // Only select when shift is pressed
                    this.classList.toggle('selected');
                    const giftId = this.dataset.id;

                    if (this.classList.contains('selected')) {
                        selectedGifts.add(giftId);
                    } else {
                        selectedGifts.delete(giftId);
                    }
                }
            });
        });

        // Handle gift validation
        document.getElementById('validateGifts').addEventListener('click', async function () {
            if (selectedGifts.size === 0) {
                alert('Please select gifts first');
                return;
            }

            try {
                const response = await fetch('/api/validate-gifts', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        gifts: Array.from(selectedGifts)
                    })
                });

                const data = await response.json();

                if (data.success) {
                    if (data.isValid) {
                        alert('Selected gifts are within your budget!');
                    } else {
                        alert('Total cost exceeds your available budget.');
                    }
                } else {
                    alert('Error validating gifts');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        function updateCard(cardElement, newGift) {
            cardElement.dataset.id = newGift.id;
            cardElement.querySelector('img').src = `/assets/${newGift.image}`;
            cardElement.querySelector('img').alt = newGift.description_cadeau;
            cardElement.querySelector('.gift-description').textContent = newGift.description_cadeau;
            cardElement.querySelector('.gift-price').textContent = `Price: ${newGift.prix}`;
            cardElement.querySelector('.gift-stars').textContent = `Stars: ${newGift.etoile}`;
        }
    });

</script>