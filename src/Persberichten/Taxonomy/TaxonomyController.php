<?php

namespace OWC\Persberichten\Taxonomy;

class TaxonomyController
{
    /**
     * Add meta input field to taxonomy add new form.
     *
     * @param string $taxonomy
     *
     * @return void
     */
    public function addMailingListField(string $taxonomy): void
    {
        if ('press_mailing_list' !== $taxonomy) {
            return;
        }

        echo '<div class="form-field">
            <label for="press_mailing_list_id">' . __('Mailinglist ID', 'persberichten') . '</label>
            <input type="text" name="press_mailing_list_id" id="press_mailing_list_id" />
            <p>' . __('The id of the mailinglist in Laposta.', 'persberichten') . '</p>
            </div>';
    }

    /**
     * Add meta input field to taxonomy edit form.
     *
     * @param object $term
     * @param string $taxonomy
     *
     * @return void
     */
    public function editMailingListField(object $term, string $taxonomy): void
    {
        if ('press_mailing_list' !== $taxonomy) {
            return;
        }

        $mailinglistID = get_term_meta($term->term_id, 'press_mailing_list_id', true);

        echo '<tr class="form-field">
            <td>
                <label for="press_mailing_list_id">' . __('Mailinglist ID', 'persberichten') . '</label>
            </td>
            <td>
                <input type="text" name="press_mailing_list_id" id="press_mailing_list_id" value="' . $mailinglistID . '" />
                <p>' . __('The id of the mailinglist in Laposta.', 'persberichten') . '</p>
            </td>
            </tr>';
    }

    /**
     * Add admin column header 'Mailinglist ID'.
     *
     * @param array $columns
     *
     * @return array
     */
    public function mailingListAdminColumnHeader(array $columns): array
    {
        $columns['press_mailing_list_id'] = __('Mailinglist ID', 'persberichten');

        return $columns;
    }

    /**
     * Admin column value for 'Mailinglist ID'.
     *
     * @param string $html
     * @param string $columnName
     * @param int $taxID
     *
     * @return string
     */
    public function mailingListAdminColumnValue(string $html, string $columnName, int $taxID): string
    {
        $maillingList = get_term($taxID, 'press_mailing_list');
        $meta         = get_term_meta($maillingList->term_id, 'press_mailing_list_id', true);

        return !empty($meta) ? $meta : 'onbekend';
    }

    public function saveMailingListField($termID): void
    {
        update_term_meta(
            $termID,
            'press_mailing_list_id',
            sanitize_text_field($_POST['press_mailing_list_id'])
        );
    }
}
